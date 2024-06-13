<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Bookmark;
use App\Models\BookMember;
use App\Models\Member;
use App\Models\Rating;
use App\Models\Record;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Smalot\PdfParser\Parser;

class BookController extends Controller
{
    public function viewAll()
    {
        $books = Book::all();
        $books = $this->calculateAverageRating($books);
        return view('books.viewall', [
            "title" => "All Books",
            "books" => $books
        ]);
    }

    public function show(Book $book)
    {
        $member = auth()->user()->member;
        return view('books.detail', [
            "title" => "Book Details",
            "book" => $book,
            "member" => $member
        ]);
    }

    public function search($query)
    {
        $results = Book::searchByName($query);
        $results = $this->calculateAverageRating($results);

        return view('books.search_results', [
            "results" => $results
        ]);
    }

    public function viewCategory($query)
    {
        $books = Book::where('category', $query)->get();

        return view('books.kategori', [
            "title" => 'Kategori',
            "books" => $books,
            "query" => $query,
        ]);
    }

    public function searchOnForum($query)
    {
        $results = Book::searchByName($query);
        return view('forum.booksearch_forum', [
            "results" => $results
        ]);
    }

    public function read(Request $request, Book $book)
    {
        $startPageNum = $request->input('startPage');

        $title = "Baca: " . $book->name;
        return view('books.read', [
            "title" => $title,
            "book" => $book,
            "startPageNum" => $startPageNum
        ]);
    }

    public function addToCollection(Request $request)
    {
        // Retrieve the authenticated member
        $member = auth()->user()->member;

        // Get the book ID from the request
        $bookId = $request->input('book_id');

        if ($member) {
            $member->books()->sync([$bookId], false);
            return redirect()->back()->with('success', 'Buku berhasil ditambahkan ke koleksi!');
        } else {
            return redirect()->back()->with('error', 'Gagal menambahkan buku. Tolong coba ulang.');
        }
    }

    public function removeFromCollection(Member $member, Book $book)
    {
        $member->books()->detach($book->id);

        return response()->json(['message' => 'Buku sudah dihapuskan dari koleksi']);
    }

    public function updateLastPage(Request $request)
    {
        $bookId = $request->input('book_id');
        $lastPage = $request->input('last_page');

        // Update the last_page value in the book_member pivot table
        $member = auth()->user()->member;
        $member->books()->updateExistingPivot($bookId, ['last_page' => $lastPage]);
        $member->books()->updateExistingPivot($bookId, ['updated_at' => now()]);

        return response()->json(['success' => true]);
    }

    public function giveRating(Book $book){
        $member = auth()->user()->member;

        $rating = Rating::where('member_id', $member->id)
            ->where('book_id', $book->id)
            ->first();

        return view('books.giverating', [
            "title" => "Give Rating",
            "book" => $book,
            "member" => $member,
            "rating" => $rating
        ]);
    }

    public function createRating(Request $request){
        $validator = Validator::make($request->all(), [
            'ratingnumber' => 'required|int|between:1,5',
            'review' => 'nullable|string|max:200',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $memberId = $request->input('member_id');
        $bookId = $request->input('book_id');

        $rating = new Rating();
        $rating->rating = $request->input('ratingnumber');
        $rating->review = $request->input('review');
        $rating->member_id = $memberId;
        $rating->book_id = $bookId;
        $rating->save();

        return redirect()->back()->with('success', 'Sukses! Anda berhasil memberi rating');
    }

    public function viewRating(){
        $member = auth()->user()->member;

        // Fetch only books that have ratings
        $books = Book::with('ratings')->has('ratings')->get();

        $books = $this->calculateAverageRating($books);

        return view('books.viewrating', [
            "title" => "View Rating",
            "books" => $books,
            "member" => $member
        ]);
    }

    public function calculateAverageRating($books){
        foreach ($books as $book) {
            $ratings = $book->ratings->pluck('rating')->toArray();
            $average_rating = count($ratings) > 0 ? array_sum($ratings) / count($ratings) : 0;
            // Round the average rating to 1 decimal point
            $book->average_rating = number_format($average_rating, 1);
        }

        return $books;
    }

    // Upload
    public function viewUpload(){
        $member = auth()->user()->member;

        $records = $member->records()->with('book')->get();

        return view('upload.unggah', [
            "title" => 'Unggah',
            "records" => $records
        ]);
    }

    public function viewBookUpload(){
        $member = auth()->user()->member;

        return view('upload.createbook', [
            "title" => 'Unggah',
            "member" => $member
        ]);
    }

    public function createBook(Request $request){
        $member = auth()->user()->member;
        $maxFileSize = $member->premium_status ? 51200 : 20480; // 50MB if premium, 20MB if not
        $validator = Validator::make($request->all(), [
            'judul' => 'required|string',
            'penulis' => ['required', 'string', 'max:50', 'regex:/^[^0-9]*$/'],
            'deskripsi' => 'required|string|max:500',
            'editor' => ['required', 'string', 'max:50', 'regex:/^[^0-9]*$/'],
            'bahasa' => 'required|string|max:20|min:2',
            'kategori' => 'required|string|max:20|min:2',
            'ISBN' => 'required|string',
            'penerbit' => 'required|string|max:50',
            'pdf_file' => 'required|mimes:pdf|max:' . $maxFileSize,
            'cover_image' => 'required|image|mimes:jpg',
        ], [
            'penulis.regex' => 'Penulis tidak boleh ada angka.',
            'editor.regex' => 'Editor tidak boleh ada angka.',
        ]);

        if ($validator->fails()) {

            return redirect()->back()->withErrors($validator)->withInput();
        }

        $pdfFilename = pathinfo($request->file('pdf_file')->getClientOriginalName(), PATHINFO_FILENAME);
        $request->file('pdf_file')->move(public_path('/books'), $pdfFilename . '.pdf');
        $pdfFullPath = public_path('books/' . $pdfFilename . '.pdf');

        // Store cover image in public/img/books directory
        $coverImageFilename = $pdfFilename . '.jpg';
        $request->file('cover_image')->move(public_path('/img/books'), $coverImageFilename);
        $imageFullPath = public_path('img/books/' . $coverImageFilename);

        // Get max pages
        $parser = new Parser();

        $pdf = $parser->parseFile($pdfFullPath);
        $totalPages = count($pdf->getPages());

        // Redesign the description
        $description = $request->input('deskripsi');
        $descriptionWithPTags = '<p>' . str_replace("\n", '</p><p>', $description) . '</p>';

        try{
            $book = new Book();
            $book->name = $request->input('judul');
            $book->description = $descriptionWithPTags;
            $book->author = $request->input('penulis');
            $book->editor = $request->input('editor');
            $book->language = $request->input('bahasa');
            $book->publisher = $request->input('penerbit');
            $book->category = $request->input('kategori');
            $book->ISBN = $request->input('ISBN');
            $book->filename = $pdfFilename;
            $book->pages = $totalPages;
            $book->save();

            $member = auth()->user()->member;
            $bookId = $book->getKey();

            $record = new Record();
            $record->book_id = $bookId;
            $record->member_id = $member->id;
            $record->uploaded_at = now();
            $record->save();

        } catch (QueryException $e){
            File::delete($pdfFullPath);
            File::delete($imageFullPath);
            if ($e->errorInfo[1] === 1062) {
                return redirect()->back()->with('error', 'Nama buku sudah ada, mohon unggah buku lain');
            }

//            return redirect()->back()->with('error', 'Terjadi error saat unggah buku.');
        }


        return redirect()->back()->with('success', 'Sukses! Buku telah diunggah!');
    }

    public function storeBookmark(Request $request)
    {
        $request->validate([
            'book_id' => 'required|integer',
            'page_number' => 'required|integer',
        ]);

        $member = auth()->user()->member;

        // Cek apakah bookmark sudah ada
        $existingBookmark = Bookmark::where('member_id', $member->id)
            ->where('book_id', $request->book_id)
            ->where('page_number', $request->page_number)
            ->first();

        if ($existingBookmark) {
            return response()->json(['success' => false, 'message' => 'Bookmark already exists']);
        }

        // Simpan bookmark baru
        Bookmark::create([
            'member_id' => $member->id,
            'book_id' => $request->book_id,
            'page_number' => $request->page_number,
        ]);

        return response()->json(['success' => true]);
    }

    public function getBookmarks($bookId)
    {
        $member = auth()->user()->member;

        $bookmarks = Bookmark::where('member_id', $member->id)
            ->where('book_id', $bookId)
            ->get(['page_number']);

        return response()->json($bookmarks);
    }

}

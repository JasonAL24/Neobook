<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Member;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    public function viewAll()
    {
        $books = Book::all();
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

    public function read(Request $request, Book $book)
    {
        $startPageNum = $request->query('startPage');

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

        // Retrieve the book
        $book = Book::find($bookId);

        if ($member) {
            $member->books()->attach($book->id);
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
            'review' => 'nullable|string|max:100',
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
}

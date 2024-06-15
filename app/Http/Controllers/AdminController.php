<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Book;
use App\Models\Community;
use App\Models\Member;
use App\Models\Record;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use OwenIt\Auditing\Facades\Auditor;
use Smalot\PdfParser\Parser;

class AdminController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.login', [
            "title" => "Admin Login"
        ]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if (Auth::guard('admin')->attempt($request->only('email', 'password'), $request->filled('remember'))) {
            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ]);
    }

    public function show()
    {
        $admin = Auth::guard('admin')->user();
        $books = Book::leftJoin('records', 'books.id', '=', 'records.book_id')
            ->where(function ($query) {
                $query->where('records.status', '!=', 'Menunggu persetujuan')
                    ->orWhereNull('records.status');
            })
            ->select('books.*')
            ->get();
        $communities = Community::all();
        $members = Member::all();
        $records = Record::all();
        $admins = Admin::all();

        if ($admin->role === 'superadmin') {
            // Superadmins can see audits for all admins
            $audits = \OwenIt\Auditing\Models\Audit::where('auditable_type', Admin::class)
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            // Regular admins can only see their own audits
            $audits = $admin->audits()->orderBy('created_at', 'desc')->get();
        }


        return view('admin.dashboard', [
            "title" => "Admin",
            "admin" => $admin,
            "audits" => $audits,
            "books" => $books,
            "communities" => $communities,
            "members" => $members,
            "records" => $records,
            "admins" => $admins
        ]);
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout(); // Logout the admin
        $request->session()->invalidate(); // Invalidate the session

        return redirect()->route('admin.login'); // Redirect to the admin login page
    }

    public function showUserList()
    {
        $members = Member::paginate(8);

        return view('admin.userlist', [
            "title" => "Daftar Pengguna",
            "members" => $members
        ]);
    }

    public function changeMemberStatus(Request $request)
    {
        $member = Member::findOrFail($request->member_id);
        $oldStatus = $member->premium_status;
        $newStatus = $request->premium_status;

        $member->premium_status = $newStatus;
        $member->save();

        $admin = auth()->guard('admin')->user(); // Get the authenticated admin
        $auditDataOld = [
            "old_status" => ($oldStatus ? "premium" : "member"),
        ];
        $auditDataNew = [
            "new_status" => ($newStatus ? "premium" : "member"),
        ];


        // Associate the audit record with the admin who performed the action
        $admin->audits()->create([
            'event' => 'Perubahan status pengguna ID ' . $member->id,
            'auditable_id' => $member->id,
            'auditable_type' => 'App\Models\Member',
            'old_values' => $auditDataOld, // Convert array to JSON
            'new_values' => $auditDataNew, // Assuming you don't want to store new values in admin's audit log
            // Add other optional fields like URL, IP address, user agent, etc. if needed
        ]);

        return redirect()->back()->with('success', 'Status Pengguna Berhasil Diubah!');
    }

    public function deleteMember(Request $request){
        $member = Member::findOrFail($request->member_id);
        $member->delete();

        return redirect()->back()->with('success', 'Pengguna Berhasil Dihapus!');
    }

    public function searchMember(Request $request)
    {
        $query = $request->input('query');
        if ($query === null){
            return redirect()->back();
        }
        $members = Member::searchByName($query);

        return view('admin.search_results.search_userlist', [
            "title" => "Daftar Pengguna",
            "members" => $members,
            "query" => $query
        ]);
    }

    public function showBookList()
    {
        $booksQuery = Book::leftJoin('records', 'books.id', '=', 'records.book_id')
            ->where(function ($query) {
                $query->where('records.status', '!=', 'Menunggu persetujuan')
                    ->orWhereNull('records.status');
            })
            ->select('books.*');

        $books = $booksQuery->paginate(8);

        return view('admin.booklist', [
            "title" => "Daftar Buku",
            "books" => $books
        ]);
    }

    public function searchBook(Request $request)
    {
        $query = $request->input('query');
        if ($query === null){
            return redirect()->back();
        }
        $books = Book::searchByName($query);

        return view('admin.search_results.search_booklist', [
            "title" => "Daftar Buku",
            "books" => $books,
            "query" => $query,
        ]);
    }

    public function showUploadForm()
    {
        return view('admin.uploadbook', [
            "title" => "Daftar Buku"
        ]);
    }

    public function createBook(Request $request){
        $validator = Validator::make($request->all(), [
            'judul' => 'required|string',
            'penulis' => ['required', 'string', 'max:50', 'regex:/^[^0-9]*$/'],
            'deskripsi' => 'required|string|max:500',
            'editor' => ['required', 'string', 'max:50', 'regex:/^[^0-9]*$/'],
            'bahasa' => 'required|string|max:20|min:2',
            'kategori' => 'required|string|max:20|min:2',
            'ISBN' => 'required|string',
            'penerbit' => 'required|string|max:50',
            'pdf_file' => 'required|mimes:pdf|max:51200',
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

        $coverImageFilename = $pdfFilename . '.jpg';
        $request->file('cover_image')->move(public_path('/img/books'), $coverImageFilename);
        $imageFullPath = public_path('img/books/' . $coverImageFilename);

        $parser = new Parser();

        $pdf = $parser->parseFile($pdfFullPath);
        $totalPages = count($pdf->getPages());

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
            $book->pdf_file = $pdfFilename;
            $book->cover_image = $pdfFilename;
            $book->pages = $totalPages;
            $book->save();

        } catch (QueryException $e){
            File::delete($pdfFullPath);
            File::delete($imageFullPath);
            if ($e->errorInfo[1] === 1062) {
                return redirect()->back()->with('error', 'Nama buku sudah ada, mohon unggah buku lain');
            }
        }


        return redirect()->back()->with('success', 'Sukses! Buku telah diunggah!');
    }

    public function showUpdateForm($id)
    {
        $book = Book::findOrFail($id);
        return view('admin.updatebook', [
            "title" => "Daftar Buku",
            "book" => $book
        ]);
    }

    public function updateBook(Request $request, $id)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'judul' => 'required|string',
            'penulis' => ['required', 'string', 'max:50', 'regex:/^[^0-9]*$/'],
            'deskripsi' => 'required|string|max:500',
            'editor' => ['required', 'string', 'max:50', 'regex:/^[^0-9]*$/'],
            'bahasa' => 'required|string|max:20|min:2',
            'kategori' => 'required|string|max:20|min:2',
            'ISBN' => 'required|string',
            'penerbit' => 'required|string|max:50',
            'pdf_file' => 'nullable|mimes:pdf|max:51200',
            'cover_image' => 'nullable|image|mimes:jpg',
        ], [
            'penulis.regex' => 'Penulis tidak boleh ada angka.',
            'editor.regex' => 'Editor tidak boleh ada angka.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Find the book by ID
        $book = Book::findOrFail($id);

        $filename = $book->name;

        // Handle PDF file if provided
        if ($request->hasFile('pdf_file')) {
            $pdfFilename = pathinfo($request->file('pdf_file')->getClientOriginalName(), PATHINFO_FILENAME);
            $request->file('pdf_file')->move(public_path('/books'), $pdfFilename . '.pdf');
            $pdfFullPath = public_path('books/' . $pdfFilename . '.pdf');

            // Update the total pages if the PDF file is updated
            $parser = new Parser();
            $pdf = $parser->parseFile($pdfFullPath);
            $totalPages = count($pdf->getPages());

            // Delete old PDF file
            File::delete(public_path('books/' . $book->pdf_file . '.pdf'));

            // Update book fields
            $book->pdf_file = $pdfFilename;
            $book->pages = $totalPages;
        }

        // Handle cover image if provided
        if ($request->hasFile('cover_image')) {
            $coverImageFilename = $filename . '.jpg';
            $request->file('cover_image')->move(public_path('/img/books'), $coverImageFilename);
            $imageFullPath = public_path('img/books/' . $coverImageFilename);

            $book->cover_image = $filename;
        }

        // Update other book fields
        $description = $request->input('deskripsi');
        $descriptionWithPTags = '<p>' . str_replace("\n", '</p><p>', $description) . '</p>';

        // Check if the title is being changed
        if ($request->input('judul') !== $book->name) {
            // Title is being changed, check uniqueness
            $validator = Validator::make($request->all(), [
                'judul' => 'unique:books,name,' . $book->id,
            ], [
                'judul.unique' => 'Nama buku sudah ada, mohon unggah buku lain.',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            // Update the title
            $book->name = $request->input('judul');
        }

        // Update other fields
        $book->description = $descriptionWithPTags;
        $book->author = $request->input('penulis');
        $book->editor = $request->input('editor');
        $book->language = $request->input('bahasa');
        $book->publisher = $request->input('penerbit');
        $book->category = $request->input('kategori');
        $book->ISBN = $request->input('ISBN');

        try {
            $book->save();
        } catch (QueryException $e) {
            if (isset($pdfFullPath)) {
                File::delete($pdfFullPath);
            }
            if (isset($imageFullPath)) {
                File::delete($imageFullPath);
            }
            if ($e->errorInfo[1] === 1062) {
                return redirect()->back()->with('error', 'Nama buku sudah ada, mohon unggah buku lain');
            }
        }

        return redirect()->back()->with('success', 'Sukses! Buku telah diperbarui!');
    }
}

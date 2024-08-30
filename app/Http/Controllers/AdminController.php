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
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
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

    // Dashboard
    public function show()
    {
        $admin = Auth::guard('admin')->user();
        $books = Book::leftJoin('records', 'books.id', '=', 'records.book_id')
            ->where(function ($query) {
                $query->where('records.status', '!=', 'Menunggu persetujuan')
                    ->where('records.status', '!=', 'Ditolak')
                    ->orWhereNull('records.status');
            })
            ->select('books.*')
            ->get();
        $communities = Community::all();
        $members = Member::all();
        $records = Record::all();
        $admins = Admin::all();
        $requests = \App\Models\Request::all();

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
            "admins" => $admins,
            "requests" => $requests
        ]);
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout(); // Logout the admin
        $request->session()->invalidate(); // Invalidate the session

        return redirect()->route('admin.login'); // Redirect to the admin login page
    }

    // Daftar Pengguna

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

        $admin = auth()->guard('admin')->user();
        $auditDataOld = [
            "old_status" => ($oldStatus ? "premium" : "member"),
        ];
        $auditDataNew = [
            "new_status" => ($newStatus ? "premium" : "member"),
        ];


        $admin->audits()->create([
            'event' => 'Perubahan status pengguna ID ' . $member->id,
            'auditable_id' => $admin->id,
            'old_values' => $auditDataOld,
            'new_values' => $auditDataNew,
        ]);

        return redirect()->back()->with('success', 'Status Pengguna Berhasil Diubah!');
    }

    public function deleteMember(Request $request){
        $member = Member::findOrFail($request->member_id);

        $admin = auth()->guard('admin')->user();
        $auditDataOld = [
            "old_status" => $member->name . " ada",
        ];
        $auditDataNew = [
            "new_status" => $member->name . " berhasil dihapus",
        ];


        $admin->audits()->create([
            'event' => 'Penghapusan pengguna ID ' . $member->id,
            'auditable_id' => $admin->id,
            'old_values' => $auditDataOld,
            'new_values' => $auditDataNew,
        ]);

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

    // Daftar Buku
    public function showBookList()
    {
        $booksQuery = Book::leftJoin('records', 'books.id', '=', 'records.book_id')
            ->where(function ($query) {
                $query->where('records.status', '!=', 'Menunggu persetujuan')
                    ->where('records.status', '!=', 'Ditolak')
                    ->orWhereNull('records.status');
            })
            ->select('books.*')
            ->orderBy('books.id');

        $books = $booksQuery->paginate(8);

        return view('admin.booklist', [
            "title" => "Daftar Buku",
            "books" => $books
        ]);
    }

    public function searchBook(Request $request)
    {
        $query = $request->input('query');

        if ($query === null) {
            return redirect()->back();
        }

        // Base query with left join and condition
        $booksQuery = Book::leftJoin('records', 'books.id', '=', 'records.book_id')
            ->where(function ($query) {
                $query->where('records.status', '!=', 'Menunggu persetujuan')
                    ->where('records.status', '!=', 'Ditolak')
                    ->orWhereNull('records.status');
            })
            ->select('books.*');

        // Apply search condition if a search term is provided
        $booksQuery = $booksQuery->where(function ($subQuery) use ($query) {
            $subQuery->whereIn('books.id', Book::searchByName($query)->pluck('id'));
        });

        // Paginate the results
        $books = $booksQuery->paginate(8);

        return view('admin.search_results.search_booklist', [
            "title" => "Daftar Buku",
            "books" => $books,
            "query" => $query,
        ]);
    }

// Mendaftar Buku
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

        $admin = auth()->guard('admin')->user();
        $auditDataOld = [
            "old_status" => "",
        ];
        $auditDataNew = [
            "new_status" => $book->name . " berhasil ditambahkan",
        ];

        $admin->audits()->create([
            'event' => 'Penambahan Buku dengan ID ' . $book->id,
            'auditable_id' => $admin->id,
            'old_values' => $auditDataOld,
            'new_values' => $auditDataNew,
        ]);


        return redirect()->back()->with('success', 'Sukses! Buku telah diunggah!');
    }

//    Update Buku (Update detail buku dan update status buku)
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

        $admin = auth()->guard('admin')->user();
        $auditDataOld = [
            "old_status" => "",
        ];
        $auditDataNew = [
            "new_status" => $book->name . " berhasil di update",
        ];


        $admin->audits()->create([
            'event' => 'Update Buku dengan ID ' . $book->id,
            'auditable_id' => $admin->id,
            'old_values' => $auditDataOld,
            'new_values' => $auditDataNew,
        ]);

        return redirect()->back()->with('success', 'Sukses! Buku telah diperbarui!');
    }

    public function updateStatus(Request $request)
    {
        $book = Book::find($request->id);

        if ($book) {
            $admin = auth()->guard('admin')->user();
            $auditDataOld = [
                "old_status" => ($book->active ? "Aktif" : "Non-Aktif"),
            ];
            $auditDataNew = [
                "new_status" => ($request->active ? "Aktif" : "Non-Aktif"),
            ];

            $admin->audits()->create([
                'event' => 'Update Status Buku dengan ID ' . $book->id,
                'auditable_id' => $admin->id,
                'old_values' => $auditDataOld,
                'new_values' => $auditDataNew,
            ]);

            $book->active = $request->active;
            $book->save();

            return response()->json(['success' => true, 'book' => $book]);
        }

        return response()->json(['success' => false], 404);
    }

//    Record List (Buku yang Diunggah)
    public function showRecordList(){
        $records = Record::paginate(8);

        return view('admin.recordlist', [
            "title" => 'Buku yang diunggah',
            "records" => $records
        ]);
    }

    public function showDetailRecordBook($id)
    {
        $book = Book::findOrFail($id);
        $record = $book->record;
        return view('admin.viewrecord', [
            "title" => "Buku yang diunggah",
            "book" => $book,
            "record" => $record
        ]);
    }

    public function approveBook($id)
    {
        $record = Record::findOrFail($id);
        $book = $record->book;


        $admin = auth()->guard('admin')->user();
        $auditDataOld = [
            "old_status" => $record->status,
        ];
        $auditDataNew = [
            "new_status" => "Disetujui",
        ];

        $admin->audits()->create([
            'event' => 'Menyetujui Buku dengan ID ' . $book->id,
            'auditable_id' => $admin->id,
            'old_values' => $auditDataOld,
            'new_values' => $auditDataNew,
        ]);

        $record->status = "Disetujui";
        $book->active = true;
        $record->save();
        $book->save();

        return redirect()->back()->with('success', 'Buku berhasil disetujui.');
    }

    public function rejectBook(Request $request, $id)
    {
        $record = Record::findOrFail($id);
        $book = $record->book;

        File::delete(public_path('books/' . $book->pdf_file . '.pdf'));
        File::delete(public_path('img/books/' . $book->cover_image . '.jpg'));

        $admin = auth()->guard('admin')->user();
        $auditDataOld = [
            "old_status" => $record->status,
        ];
        $auditDataNew = [
            "new_status" => "Ditolak",
        ];

        $admin->audits()->create([
            'event' => 'Menolak Buku dengan ID ' . $book->id,
            'auditable_id' => $admin->id,
            'old_values' => $auditDataOld,
            'new_values' => $auditDataNew,
        ]);

        $record->status = "Ditolak";
        $record->rejectReason = $request->input('rejectReason');
        $record->save();

        return redirect()->back()->with('success', 'Buku berhasil ditolak');
    }

    public function showCommunityList(){
        $communities = Community::paginate(8);

        return view('admin.communitylist', [
            "title" => 'Daftar Komunitas',
            "communities" => $communities
        ]);
    }

    public function changeCommunityStatus(Request $request)
    {
        $community = Community::findOrFail($request->community_id);
        $oldStatus = $community->active;
        $newStatus = $request->community_status;

        $community->active = $newStatus;
        $community->save();

        $admin = auth()->guard('admin')->user();
        $auditDataOld = [
            "old_status" => ($oldStatus ? "Aktif" : "Non Aktif"),
        ];
        $auditDataNew = [
            "new_status" => ($newStatus ? "Aktif" : "Non Aktif"),
        ];


        $admin->audits()->create([
            'event' => 'Perubahan status komunitas ID ' . $community->id,
            'auditable_id' => $admin->id,
            'old_values' => $auditDataOld,
            'new_values' => $auditDataNew,
        ]);

        return redirect()->back()->with('success', 'Status Komunitas Berhasil Diubah!');
    }

    public function searchCommunity(Request $request)
    {
        $query = $request->input('query');
        if ($query === null){
            return redirect()->back();
        }
        $communities = Community::searchByName($query);

        return view('admin.search_results.search_communitylist', [
            "title" => "Daftar Komunitas",
            "communities" => $communities,
            "query" => $query
        ]);
    }

    public function showAdminList(){
        $admins = Admin::paginate(8);

        return view('admin.adminlist', [
            "title" => 'Daftar Admin',
            "admins" => $admins
        ]);
    }

    public function searchAdmin(Request $request){
        $query = $request->input('query');
        if ($query === null){
            return redirect()->back();
        }
        $admins = Admin::searchByName($query);

        return view('admin.search_results.search_adminlist', [
            "title" => 'Daftar Admin',
            "admins" => $admins,
            "query" => $query
        ]);
    }

    public function showAddAdmin(){
        return view('admin.addadmin', [
            "title" => 'Daftar Admin'
        ]);
    }

    public function addAdmin(Request $request)
    {
        Validator::extend('custom_email', function ($attribute, $value, $parameters, $validator) {
            return filter_var($value, FILTER_VALIDATE_EMAIL) && preg_match('/^[^@\s]+@[^@\s]+\.[^@\s]+$/', $value);
        });

        $request->validate([
            'nama' => 'required|string|max:255|regex:/^[a-zA-Z ]+$/',
            'email' => 'required|string|custom_email|max:255|unique:admins',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'nama.regex' => 'Nama tidak boleh berupa angka/simbol',
        ]);

        $admin = auth()->guard('admin')->user();

        if (!Hash::check($request->confirmation_password, $admin->password)) {
            return redirect()->back()->withErrors(['confirmation_password' => 'Kata sandi anda tidak sesuai!'])->withInput();
        }

        Admin::create([
            'name' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->back()->with('success', 'Admin berhasil ditambahkan.');
    }

    public function showSettings(){
        $admin = auth()->guard('admin')->user();

        return view('admin.pengaturan', [
            "title" => 'Pengaturan',
            "admin" => $admin
        ]);
    }

    public function updateSettings(Request $request, $id)
    {
        Validator::extend('custom_email', function ($attribute, $value, $parameters, $validator) {
            return filter_var($value, FILTER_VALIDATE_EMAIL) && preg_match('/^[^@\s]+@[^@\s]+\.[^@\s]+$/', $value);
        });

        $request->validate([
            'nama' => 'required|string|max:255|regex:/^[a-zA-Z ]+$/',
            'email' => [
                'required',
                'string',
                'custom_email',
                'max:255',
                Rule::unique('admins')->ignore($id),
            ],
            'password' => 'nullable|string|min:8|confirmed',
        ], [
            'nama.regex' => 'Nama tidak boleh berupa angka/simbol',
        ]);

        $admin = auth()->guard('admin')->user();

        if (!Hash::check($request->confirmation_password, $admin->password)) {
            return redirect()->back()->withErrors(['confirmation_password' => 'Kata sandi anda tidak sesuai!'])->withInput();
        }

        $admin->name = $request->nama;
        $admin->email = $request->email;

        if ($request->password) {
            $admin->password = Hash::make($request->password);
        }

        $admin->save();

        return redirect()->back()->with('success', 'Admin berhasil diperbarui.');
    }

    public function showRequestList(Request $request){
        $query = \App\Models\Request::query();

        if ($request->has('tipePermohonan') && $request->tipePermohonan != '') {
            $query->where('type', $request->tipePermohonan);
        }
        $query->orderBy('created_at', 'desc');
        $requests = $query->paginate(8);

        return view('admin.requestlist', [
            "title" => 'Daftar Permohonan',
            "requests" => $requests
        ]);
    }
}

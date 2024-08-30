<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CommunityChatController;
use App\Http\Controllers\CommunityController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ForumController;
use App\Models\Book;
use App\Models\Category;
use App\Models\ForumPost;
use App\Models\Post;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::redirect('/', '/login');

Route::get('/register', [UserController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [UserController::class, 'register']);

Route::get('/login', [UserController::class, 'showLoginForm'])->name('login');
Route::post('/login', [UserController::class, 'login']);

Route::post('/logout', [UserController::class, 'logout'])->name('logout');
Route::redirect('/logout', '/login');

Route::get('forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('reset-password/{token}', [ForgotPasswordController::class, 'showResetForm'])
    ->name('password.reset');
Route::post('reset-password', [ForgotPasswordController::class, 'reset'])->name('password.update');


Route::middleware('auth')->group(function () {
    Route::get('/home', [HomeController::class, 'showHome']);

//  BOOKS
    Route::get('/viewallbooks', [BookController::class, 'viewAll'])->name('books.viewall');
    Route::get('/books/{book}', [BookController::class, 'show']);

    Route::post('/add-to-collection', [BookController::class, 'addToCollection'])
        ->name('add-to-collection');

    Route::delete('/members/{member}/books/{book}', [BookController::class, 'removeFromCollection'])->name('members.books.remove');

    Route::post('/update-last-page', [BookController::class, 'updateLastPage'])->name('update-last-page');

    Route::get('/books/{book}/read', [BookController::class, 'read']);
    Route::post('/bookmarks', [BookController::class, 'storeBookmark']);
    Route::get('/bookmarks/{bookId}', [BookController::class, 'getBookmarks']);

    Route::get('/search/{query}', [BookController::class, 'search']);
    Route::get('/kategori/{query}', [BookController::class, 'viewCategory']);

    Route::get('/books/{book}/giverating', [BookController::class, 'giveRating'])->name('books.giverating');
    Route::post('/giverating', [BookController::class, 'createRating'])->name('books.createrating');

    Route::get('/viewrating', [BookController::class, 'viewRating'])->name('books.viewRating');


//    FORUM
    Route::get('/forumdiskusi', [ForumController::class, 'index'])->name('forum.index');
    Route::get('/forumdiskusi/{forumpost}', [ForumController::class, 'showDetailForum']);
    Route::post('/forumdiskusi/addcomment', [ForumController::class, 'addComment'])->name('addComment');
    Route::post('/forumdiskusi/addreply', [ForumController::class, 'addReply'])->name('addReply');

    Route::get('/search-books', [ForumController::class, 'searchBooks']);

    Route::get('/forumsaya', [ForumController::class, 'showPost']);

    Route::get('/buatforum', function () {
        $books = \App\Models\Book::all()->toArray();
        $bookNames = \App\Models\Book::pluck('name');
        return view('forum.buatforum', [
            "title" => "Buat Forum",
            "books" => $books,
            "bookNames" => $bookNames
        ]);
    });

    Route::post('add', [ForumController::class,'addData'])->name('addForum');

    Route::get('/buatforum/search/{query}', [BookController::class, 'searchOnForum']);


//    KOLEKSI
    Route::get('/koleksi', function () {
        $books = \App\Models\Book::all();
        $books = (new BookController())->calculateAverageRating($books);
        return view('koleksi', [
            "title" => "Koleksi",
            "books" => $books
        ]);
    });

//    UPLOAD
    Route::get('/unggah', [BookController::class, 'viewUpload'])->name('viewUpload');
    Route::get('/unggah/buat', [BookController::class, 'viewBookUpload'])->name('viewBookUpload');
    Route::post('/unggah/buat', [BookController::class, 'createBook'])->name('createBook');

//    KOMUNITAS
    Route::get('/komunitas', [CommunityController::class, 'viewAll'])->name('viewAllCommunity');
    Route::get('/komunitas/saya', [CommunityController::class, 'showMyCommunity'])->name('community.mylist');
    Route::get('/komunitas/{community}', [CommunityController::class, 'viewDetail'])->name('community.detail');
    Route::get('/komunitas/{community}/members', [CommunityController::class, 'viewMembers'])->name('community.members');
    Route::post('/community/{community}/join', [CommunityController::class, 'join'])->name('community.join');
    Route::get('/komunitas/search/{query}', [CommunityController::class, 'search'])->name('search.community');
    Route::get('/buatkomunitas', [CommunityController::class, 'viewCreateCommunity']);
    Route::post('/buatkomunitas', [CommunityController::class, 'createCommunity'])->name('community.create');
    Route::post('/komunitas/{community}/createannouncement', [CommunityController::class, 'createAnnouncement'])->name('community.createAnnouncement');
    Route::delete('/community/{community}/member/{member}', [CommunityController::class, 'removeMember'])->name('community.member.delete');

    Route::post('/community/{community}/upload-background-cover', [CommunityController::class, 'updateBackgroundCover'])->name('community.upload.background');
    Route::post('/community/{community}/upload-profile-picture', [CommunityController::class, 'updateProfilePicture'])->name('community.upload.pp');

//    CHATS
    Route::get('/chats', [CommunityChatController::class, 'index'])->name('community.chat.index');
    Route::get('/chats/{community}', [CommunityChatController::class, 'show'])->name('community.chat.show');
    Route::post('/chats/{community}', [CommunityChatController::class, 'store'])->name('community.chat.store');

//    LANGGANAN
    Route::get('/langganan', function () {
        return view('langganan', [
            "title" => "Langganan"
        ]);
    });
    Route::post('/subscribe', [UserController::class, 'subscribe'])->name('subscribe');
    Route::get('/qris', [UserController::class, 'showQris'])->name('qris');

//    PENGATURAN
    Route::get('/pengaturan', function () {
        return view('pengaturan', [
            "title" => "Pengaturan"
        ]);
    });

//    PROFILE
    Route::get('/profile', function () {
        return view('profile', [
            "title" => "Pengaturan"
        ]);
    })->name('profile');

    Route::post('/update-profile-picture', [UserController::class, 'updateProfilePicture'])
        ->name('upload.profile.picture');

    Route::put('/members/{id}', [UserController::class, 'update'])->name('members.update');

    // NOTIFICATION
    Route::get('/notification/read/{id}', [NotificationController::class, 'markAsRead'])->name('notification.read');

    // BOOK REQUEST & COMPLAINS
    Route::get('/permohonan', [UserController::class, 'showRequestPage'])->name('request.page');
    Route::post('/permohonan/upload', [UserController::class, 'uploadRequest'])->name('request.upload');
});

// ADMIN
Route::get('/admin/login', [AdminController::class, 'showLoginForm'])->name('admin.login.form');
Route::post('/admin/login', [AdminController::class, 'login'])->name('admin.login');

Route::middleware(['admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'show'])->name('admin.dashboard');
    Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');

    // User List
    Route::get('/admin/userlist', [AdminController::class, 'showUserList'])->name('admin.userlist');
    Route::post('/change-member-status', [AdminController::class, 'changeMemberStatus'])
        ->name('admin.members.change-status');
    Route::delete('/deletemember', [AdminController::class, 'deleteMember'])->name('admin.member.delete');
    Route::get('/admin/userlist/search', [AdminController::class, 'searchMember'])->name('admin.member.search');


    // Book List
    Route::get('/admin/booklist', [AdminController::class, 'showBookList'])->name('admin.booklist');
    Route::get('/admin/booklist/search', [AdminController::class, 'searchBook'])->name('admin.books.search');
    Route::get('/admin/booklist/uploadbook', [AdminController::class, 'showUploadForm'])->name('admin.books.upload');
    Route::post('/admin/booklist/uploadbook', [AdminController::class, 'createBook'])->name('admin.create.book');

    Route::get('/admin/booklist/updatebook/{id}/edit', [AdminController::class, 'showUpdateForm'])->name('admin.books.update');
    Route::put('/admin/booklist/updatebook/{id}', [AdminController::class, 'updateBook'])->name('admin.update.book');
    Route::post('/admin/booklist/update-status', [AdminController::class, 'updateStatus'])->name('book.updateStatus');

    // Uploaded Books List
    Route::get('/admin/uploadedbooks', [AdminController::class, 'showRecordList'])->name('admin.recordlist');
    Route::get('/admin/uploadedbooks/{id}/view', [AdminController::class, 'showDetailRecordBook'])->name('admin.book.detail');
    Route::post('/admin/uploadedbooks/{id}/approved', [AdminController::class, 'approveBook'])->name('admin.book.approve');
    Route::post('/admin/uploadedbooks/{id}/rejected', [AdminController::class, 'rejectBook'])->name('admin.book.reject');

    // Community List
    Route::get('/admin/communitylist', [AdminController::class, 'showCommunityList'])->name('admin.communitylist');
    Route::get('/admin/communitylist/search', [AdminController::class, 'searchCommunity'])->name('admin.community.search');
    Route::post('/change-community-status', [AdminController::class, 'changeCommunityStatus'])
        ->name('admin.community.change-status');
    Route::get('/admin/communitylist/search', [AdminController::class, 'searchCommunity'])->name('admin.community.search');

    //Request List
    Route::get('/admin/requestlist', [AdminController::class, 'showRequestList'])->name('admin.requestlist');


    // Admin List
    Route::get('/admin/adminlist', [AdminController::class, 'showAdminList'])->name('admin.adminlist');
    Route::get('/admin/adminlist/search', [AdminController::class, 'searchAdmin'])->name('admin.admins.search');
    Route::get('/admin/adminlist/add', [AdminController::class, 'showAddAdmin'])->name('admin.admins.add');
    Route::post('/admin/adminlist/add', [AdminController::class, 'addAdmin'])->name('admin.add');


    // Pengaturan
    Route::get('/admin/pengaturan', [AdminController::class, 'showSettings'])->name('admin.settings');
    Route::put('/admin/pengaturan/{id}', [AdminController::class, 'updateSettings'])->name('admin.update');

});





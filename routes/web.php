<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\CommunityChatController;
use App\Http\Controllers\CommunityController;
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


Route::middleware('auth')->group(function () {
    Route::get('/home', function () {
        $book = \App\Models\Book::all();
        $member = auth()->user()->member;

        $booksWithRating = Book::with('ratings')->has('ratings')->get();
        $booksWithRating = (new BookController())->calculateAverageRating($booksWithRating);

        $communities = $member->communities()->with(['messages' => function($query) {
            $query->latest()->first();
        }])->get();

        $communitiesWithLastMessage = $communities->map(function ($community) {
            $community->lastMessage = $community->messages->first();
            return $community;
        });

        $isMemberPremium = $member->premium_status;

        $forumPosts = ForumPost::with(['member', 'member.user', 'book'])->get();

        return view('home', [
            "title" => "Home",
            "books" => $book,
            "member" => $member,
            "booksWithRating" => $booksWithRating,
            "communitiesWithLastMessage" => $communitiesWithLastMessage,
            "isMemberPremium" => $isMemberPremium,
            "forumPosts" => $forumPosts,
        ]);
    });

//  BOOKS
    Route::get('/viewallbooks', [BookController::class, 'viewAll'])->name('books.viewall');
    Route::get('/books/{book}', [BookController::class, 'show']);

    Route::post('/add-to-collection', [BookController::class, 'addToCollection'])
        ->name('add-to-collection');

    Route::delete('/members/{member}/books/{book}', [BookController::class, 'removeFromCollection'])->name('members.books.remove');

    Route::post('/update-last-page', [BookController::class, 'updateLastPage'])->name('update-last-page');

    Route::get('/books/{book}/read', [BookController::class, 'read']);

    Route::get('/search/{query}', [BookController::class, 'search']);
    Route::get('/kategori/{query}', [BookController::class, 'viewCategory']);

    Route::get('/books/{book}/giverating', [BookController::class, 'giveRating'])->name('books.giverating');
    Route::post('/giverating', [BookController::class, 'createRating'])->name('books.createrating');

    Route::get('/viewrating', [BookController::class, 'viewRating'])->name('books.viewRating');


//    FORUM
    Route::get('/forumdiskusi', [ForumController::class, 'index']);
    Route::get('/forumdiskusi/{forumpost}', [ForumController::class, 'showDetailForum']);
    Route::post('/forumdiskusi/addcomment', [ForumController::class, 'addComment'])->name('addComment');
    Route::post('/forumdiskusi/addreply', [ForumController::class, 'addReply'])->name('addReply');

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
    Route::post('/subscribe', [UserController::class, 'subscribe']);

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
});





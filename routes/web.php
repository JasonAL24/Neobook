<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\PostController;
use App\Models\Category;
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

Route::get('/', function () {
    $books = [
        [
            'id' => 1,
            'name' => 'Harry Potter and the Deathly Hallows',
            'image' => '/img/books/harry_potter_and_the_deathly_hallows.png',
            'type' => 'novel',
            'rating' => 4,
            'last_rating_date' => '26-04-2023',
            'last_rating_desc' => 'The Best! Recommended parah bagi pecinta buku JK Rowling, semua adegannya seru banget!'
        ],
        [
            'id' => 2,
            'name' => 'Fantastic Beasts and Where to Find Them',
            'image' => '/img/books/fantastic_beasts_and_where_to_find_them.png',
            'type' => 'novel',
            'rating' => 5,
            'last_rating_date' => '20-03-2023',
            'last_rating_desc' => 'Ini buku adventure yang sangat menarik bagi saya karena buku ini menceritakan banyak hal mengenai monster-monster fantasi'
        ],
        [
            'id' => 3,
            'name' => 'Game of Thrones',
            'image' => '/img/books/game_of_thrones.png',
            'type' => 'novel',
            'rating' => 5,
            'last_rating_date' => '04-05-2023',
            'last_rating_desc' => 'Saya tidak sabar untuk melanjutkan seri ini. Plot yang kompleks dan karakter yang kuat membuatnya sulit untuk dilepaskan.'
        ],
        [
            'id' => 4,
            'name' => "The Wise Man's Fear",
            'image' => '/img/books/the_wise_man_fear.png',
            'type' => 'novel',
            'rating' => 5,
            'last_rating_date' => '20-04-2023',
            'last_rating_desc' => 'Novel yang sangat menghibur dan penuh dengan misteri. Saya menikmati setiap halaman dan tidak sabar untuk membaca lebih banyak.'
        ],
        [
            'id' => 5,
            'name' => "Kedamaian",
            'image' => '/img/books/kedamaian.png',
            'type' => 'cerpen',
            'rating' => 4,
            'last_rating_date' => '17-04-2023',
            'last_rating_desc' => 'Buku ini memberikan pesan yang sangat dalam tentang perdamaian dan keselarasan. Saya sangat terinspirasi setelah membacanya.'
        ],
        [
            'id' => 6,
            'name' => "Obsesi",
            'image' => '/img/books/obsesi.png',
            'type' => 'cerpen',
            'rating' => 3,
            'last_rating_date' => '15-04-2023',
            'last_rating_desc' => 'Cerita yang menarik dengan alur yang cukup kompleks, meskipun ada beberapa bagian yang agak lambat.'
        ],
        [
            'id' => 7,
            'name' => "Izinkan Perempuan Bicara",
            'image' => '/img/books/izinkan_perempuan.png',
            'type' => 'cerpen',
            'rating' => 4,
            'last_rating_date' => '07-04-2023',
            'last_rating_desc' => 'Buku ini mengangkat isu-isu yang penting dan memberikan pandangan yang menarik tentang peran perempuan dalam masyarakat.'

        ],
        [
            'id' => 8,
            'name' => "Lukisan Senja",
            'image' => '/img/books/lukisan_senja.png',
            'type' => 'cerpen',
            'rating' => 4,
            'last_rating_date' => '07-01-2023',
            'last_rating_desc' => 'Novel yang penuh dengan emosi dan keindahan. Saya terpesona dengan cara penulis menggambarkan karakter dan suasana.'

        ],
    ];
    $book = \App\Models\Book::all()->toArray();
    return view('home', [
        "title" => "Home",
        "books" => $books
    ]);
});

Route::get('/books/{book}', [BookController::class, 'show']);

Route::get('/books/{book}/read', [BookController::class, 'read']);

Route::get('/search/{query}', [BookController::class, 'search']);

Route::get('/forum', function () {
    return view('forum', [
        "title" => "Forum"
    ]);
});

Route::get('/koleksi', function () {
    return view('koleksi', [
        "title" => "Koleksi"
    ]);
});

Route::get('/unggah', function () {
    return view('unggah', [
        "title" => "Unggah"
    ]);
});

Route::get('/komunitas', function () {
    return view('komunitas', [
        "title" => "Komunitas"
    ]);
});

Route::get('/langganan', function () {
    return view('langganan', [
        "title" => "Langganan"
    ]);
});

Route::get('/pengaturan', function () {
    return view('pengaturan', [
        "title" => "Pengaturan"
    ]);
});

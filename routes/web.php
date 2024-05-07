<?php

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
            'name' => 'Harry Potter and the Deathly Hallows',
            'image' => 'img/books/harry_potter.png'
        ],
        [
            'name' => 'Fantastic Beasts and Where to Find Them',
            'image' => 'img/books/fantastic_beasts.png'
        ],
        [
            'name' => 'Game of Thrones',
            'image' => 'img/books/game_of_thrones.png'
        ],
        [
            'name' => "The Wise Man's Fear",
            'image' => 'img/books/wise_man_fear.png'
        ],
    ];
    $original_books = [
        [
            'name' => "Kedamaian",
            'image' => 'img/books/kedamaian.png'
        ],
        [
            'name' => "Obsesi",
            'image' => 'img/books/obsesi.png'
        ],
        [
            'name' => "Izinkan Perempuan Bicara",
            'image' => 'img/books/izinkan_perempuan.png'
        ],
        [
            'name' => "Lukisan Senja",
            'image' => 'img/books/lukisan_senja.png'
        ],
    ];
    return view('home', [
        "title" => "Home",
        "books" => $books,
        "originalBooks" => $original_books
    ]);
});


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

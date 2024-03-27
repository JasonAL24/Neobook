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
    return view('home', [
        "title" => "Home"
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
//Route::get('/about', function () {
//    return view('about', [
//        "title" => "About",
//        "name" => "Jason Aldeo",
//        "email" => "jasonaldeo@gmail.com",
//        "image" => "pp.png"
//    ]);
//});
//
//Route::get('/posts', [PostController::class, 'index']);
//
//Route::get('/posts/{post:slug}', [PostController::class, 'show']);
//
//Route::get('/categories', function (){
//    return view('categories', [
//        'title' => 'Post Categories',
//        'categories' => Category::all(),
//    ]);
//});
//
//Route::get('/categories/{category:slug}', function (Category $category){
//    return view('category', [
//        'title' => $category->name,
//        'posts' => $category->posts,
//        'category' => $category->name
//    ]);
//});

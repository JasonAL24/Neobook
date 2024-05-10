<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function show(Book $book)
    {
        return view('books.detail', [
            "title" => "Book Details",
            "book" => $book
        ]);
    }

    public function search($query)
    {
        $results = Book::searchByName($query);
        return view('books.search_results', [
            "title" => "Search Result",
            "results" => $results
        ]);
    }
}

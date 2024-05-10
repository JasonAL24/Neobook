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
            "results" => $results
        ]);
    }

    public function read(Request $request, Book $book)
    {
        $startPageNum = $request->query('startPage');

        $title = "Read: " . $book->name; // Assuming 'name' is the attribute that holds the book name
        return view('books.read', [
            "title" => $title,
            "book" => $book,
            "startPageNum" => $startPageNum
        ]);
    }
}

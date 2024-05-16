<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Member;
use Illuminate\Http\Request;

class BookController extends Controller
{
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
        return view('books.search_results', [
            "results" => $results
        ]);
    }

    public function searchOnForum($query)
    {
        $results = Book::searchByName($query);
        return view('forum.booksearch_forum', [
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
}

<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\ForumPost;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function showHome(){
        $books = Book::where('active', true)->get();
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
            "books" => $books,
            "member" => $member,
            "booksWithRating" => $booksWithRating,
            "communitiesWithLastMessage" => $communitiesWithLastMessage,
            "isMemberPremium" => $isMemberPremium,
            "forumPosts" => $forumPosts,
        ]);
    }
}

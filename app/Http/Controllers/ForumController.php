<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ForumPost;
use Nette\Schema\ValidationException;

class ForumController extends Controller
{
    public function index()
    {
        $posts = ForumPost::with(['member', 'member.user', 'book'])->get();
        return view('forum.forumdiskusi', [
            'title' => 'Forum Diskusi',
            'posts' => $posts
        ]);
    }

    function addData(Request $req)
    {
        try {
            $forumpost = new ForumPost;
            $forumpost->member_id = auth()->user()->member->id;
            $forumpost->title = $req->title;
            $forumpost->book_id = $req->input('book_id'); // Ensure this retrieves the correct value
            $forumpost->content = $req->input('content');
            $forumpost->save();

            return redirect()->back()->with('success', 'Forum Berhasil Dibuat.');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->validator->errors())->withInput();
        }
    }

}

<?php

namespace App\Http\Controllers;

use App\Models\ForumComment;
use App\Models\ForumReply;
use App\Models\Member;
use Illuminate\Http\Request;
use App\Models\ForumPost;
use Illuminate\Support\Facades\Validator;
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

    public function showPost()
    {
        $posts = auth()->user()->member->forumPosts;
        return view('forum.forumsaya', [
            'title' => 'Forum Saya',
            'posts' => $posts
        ]);
    }

    public function showDetailForum(ForumPost $forumpost)
    {
        return view('forum.forumdetail', [
            'title' => 'Forum Diskusi',
            'post' => $forumpost
        ]);
    }

    function addData(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'title' => 'required|string|max:50',
            'content' => 'required|string|max:100',
            'book_id' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $forumpost = new ForumPost;
        $forumpost->member_id = auth()->user()->member->id;
        $forumpost->title = $req->title;
        $forumpost->book_id = $req->input('book_id');
        $forumpost->content = $req->input('content');
        $forumpost->save();

        return redirect()->back()->with('success', 'Forum Berhasil Dibuat.');
    }

    function addComment(Request $req)
    {
        $member = auth()->user()->member;

        $validator = Validator::make($req->all(), [
            'commentContent' => 'required|string|max:100',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $forumcomment = new ForumComment([
            'content' => $req->input('commentContent'),
            'member_id' => $member->id,
            'forum_post_id' => $req->input('forum_post_id')
        ]);

        $forumcomment->save();

        return redirect()->back()->with('success', 'Komentar Berhasil Dibuat.');
    }

    function addReply(Request $req)
    {
        $member = auth()->user()->member;

        $validator = Validator::make($req->all(), [
            'replyContent' => 'required|string|max:100',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $forumreply = new ForumReply([
            'content' => $req->input('replyContent'),
            'member_id' => $member->id,
            'forum_comment_id' => $req->input('forum_comment_id')
        ]);

        $forumreply->save();

        return redirect()->back()->with('success', 'Reply Berhasil Dibuat.');
    }

}

<?php

namespace App\Http\Controllers;

use App\Models\ForumComment;
use App\Models\ForumReply;
use App\Models\Member;
use App\Models\Notification;
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
            'title' => 'required|string|max:100',
            'content' => 'required|string|max:250',
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

        $commentContent = $req->input('commentContent');

        $forumcomment = new ForumComment([
            'content' => $commentContent,
            'member_id' => $member->id,
            'forum_post_id' => $req->input('forum_post_id')
        ]);
        $forumcomment->save();

        $forumPost = ForumPost::find($req->input('forum_post_id'));
        $forumName = $forumPost->title;
        $forumMemberId = $req->input('forum_member_id');

        if ((int) $forumMemberId !== (int) $member->id){
            $notification = new Notification();
            $notification->member_id = $forumMemberId;
            $notification->content = 'Ada komentar baru di forum "'. $forumName . '": '. $commentContent . '. Klik di sini untuk melihatnya.';
            $notification->link = '/forumdiskusi/' . $forumPost->id;
            $notification->save();
        }

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

        $forumPost = ForumPost::find($req->input('forum_post_id'));

        if ((int) $req->input('comment_member_id') !== (int) $member->id){
            $notification = new Notification();
            $notification->member_id = $req->input('comment_member_id');
            $notification->content = 'Komentar Anda baru saja dibalas! Klik di sini untuk melihat balasannya.';
            $notification->link = '/forumdiskusi/' . $forumPost->id;
            $notification->save();
        }

        $forumreply->save();

        return redirect()->back()->with('success', 'Reply Berhasil Dibuat.');
    }

}

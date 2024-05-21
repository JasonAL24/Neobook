<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Community;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class CommunityChatController extends Controller
{
    public function index()
    {
        $member = Auth::user()->member;
        $communities = $member->communities()->with(['messages' => function($query) {
            $query->latest()->first();
        }])->get();

        $communitiesWithLastMessage = $communities->map(function ($community) {
            $community->lastMessage = $community->messages->first();
            return $community;
        });

        return view('community.chat.index', [
            'communitiesWithLastMessage' => $communitiesWithLastMessage
        ]);

    }

    public function show(Community $community)
    {
        $messages = $community->messages()->with('member.user')->latest()->get();

        foreach ($messages as $message) {
            $message->created_at = $message->created_at->timezone('Asia/Jakarta');
        }

        return view('community.chat.show', compact('community', 'messages'));
    }

    public function store(Request $request, Community $community)
    {
        $request->validate([
            'content' => 'required|string',
        ]);

        $member = Auth::user()->member;

        $message = new Message([
            'content' => $request->input('content'),
        ]);

        $message->member()->associate($member);
        $message->community()->associate($community);
        $message->save();

        broadcast(new MessageSent($message))->toOthers();

        return response()->json([
            'success' => true,
            'message' => $message->load('member')
        ]);
    }
}

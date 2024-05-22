<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Community;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CommunityController extends Controller
{
    public function viewAll(){
        $communities = Community::all();

        $communitiesWithLastMessage = $this->getCommunitiesWithLastMessage();

        return view('community.komunitas', [
            "title" => "Komunitas",
            "communities" => $communities,
            'communitiesWithLastMessage' => $communitiesWithLastMessage
        ]);
    }

    public function viewDetail(Community $community){
        $members = $community->members;

        $authenticatedMemberId = Auth::user()->member->id;

        // Check if the authenticated user has joined the community
        $isMember = $community->communityMembers->contains('member_id', $authenticatedMemberId);

        $membershipStatus = null;
        $isModerator = false;
        if ($isMember) {
            $membershipStatus = $community->communityMembers
                ->where('member_id', $authenticatedMemberId)
                ->first()
                ->membership_status;

            // Check if the user is a moderator
            $isModerator = $membershipStatus === 'moderator';
        }

        $moderators = $community->communityMembers()
            ->where('membership_status', 'moderator')
            ->with('member')
            ->get();

        $announcements = $community->announcements;

        $communitiesWithLastMessage = $this->getCommunitiesWithLastMessage();

        return view('community.detailkomunitas', [
            "title" => "Komunitas",
            "community" => $community,
            "members" => $members,
            "isMember" => $isMember,
            "moderators" => $moderators,
            "isModerator" => $isModerator,
            "announcements" => $announcements,
            'communitiesWithLastMessage' => $communitiesWithLastMessage
        ]);
    }

    private function getCommunitiesWithLastMessage(){
        $member = Auth::user()->member;
        $communitiesMessage = $member->communities()->with(['messages' => function($query) {
            $query->latest()->first();
        }])->get();

        return $communitiesMessage->map(function ($community) {
            $community->lastMessage = $community->messages->first();
            return $community;
        });
    }

    public function join(Community $community)
    {
        $authenticatedMemberId = Auth::user()->member->id;

        if (!$community->communityMembers->contains('member_id', $authenticatedMemberId)) {
            $community->communityMembers()->create([
                'member_id' => $authenticatedMemberId,
                'membership_status' => 'anggota',
            ]);
        }

        return redirect()->route('community.detail', ['community' => $community]);
    }

    public function createAnnouncement(Request $request, Community $community)
    {
        $validator = Validator::make($request->all(), [
            'judul' => 'required|string|max:50',
            'isi' => 'required|string|max:100',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Create the announcement
        $announcement = new Announcement([
            'title' => $request->input('judul'),
            'content' => $request->input('isi'),
        ]);

        $community->announcements()->save($announcement);

        return redirect()->route('community.detail', ['community' => $community]);
    }

    public function search($query)
    {
        $results = Community::searchByName($query);

        return view('community.search_results', [
            "results" => $results
        ]);
    }
}

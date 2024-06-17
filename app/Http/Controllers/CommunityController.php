<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Book;
use App\Models\Community;
use App\Models\CommunityMember;
use App\Models\Member;
use App\Models\Record;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Smalot\PdfParser\Parser;

class CommunityController extends Controller
{
    public function viewAll(){
        $communities = Community::where('active', true)->get();

        $communitiesWithLastMessage = $this->getCommunitiesWithLastMessage();

        return view('community.komunitas', [
            "title" => "Komunitas",
            "communities" => $communities,
            'communitiesWithLastMessage' => $communitiesWithLastMessage
        ]);
    }

    public function viewDetail(Community $community){
        if (!$community->active) {
            abort(404);
        }

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
        $results = Community::searchByName($query)->where('active', true);
        $communitiesWithLastMessage = $this->getCommunitiesWithLastMessage();

        return view('community.search_results', [
            "title" => "Komunitas",
            "results" => $results,
            "query" => $query,
            "communitiesWithLastMessage" => $communitiesWithLastMessage
        ]);
    }

    public function viewMembers(Community $community){
        $members = $community->members;

        $authenticatedMemberId = Auth::user()->member->id;

        $communityMembers = $community->communityMembers()
            ->get();

        $isMember = $community->communityMembers->contains('member_id', $authenticatedMemberId);

        $isModerator = false;
        if ($isMember) {
            $membershipStatus = $community->communityMembers
                ->where('member_id', $authenticatedMemberId)
                ->first()
                ->membership_status;

            $isModerator = $membershipStatus === 'moderator';
        }

        return view('community.members', [
            "title" => "Komunitas",
            "community" => $community,
            "members" => $members,
            "communityMembers" => $communityMembers,
            "isModerator" => $isModerator
        ]);
    }

    public function removeMember(Community $community, Member $member){
        $communityMember = CommunityMember::where('community_id', $community->id)
            ->where('member_id', $member->id)
            ->first();

        if ($communityMember) {
            $communityMember->delete();
            return response()->json(['message' => 'Member sudah dikick']);
        }

        return response()->json(['message' => 'Member tidak ditemukan'], 404);
    }

    public function updateProfilePicture(Request $request, Community $community)
    {
        try {
            $request->validate([
                'profile_picture' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $id = $community->id;

            $existingProfilePicture = $community->profile_picture;
            if ($existingProfilePicture) {
                $filePath = "/img/communities/profile_picture/$id/$existingProfilePicture";
                $fileFullPath = public_path($filePath);
                File::delete($fileFullPath);
            }

            $profilePicture = $request->file('profile_picture');
            $fileName = time() . '.' . $profilePicture->getClientOriginalExtension();

            $directory = "/img/communities/profile_picture/$id";
            if (!Storage::exists($directory)) {
                Storage::makeDirectory($directory);
            }

            $profilePicture->move(public_path($directory), $fileName);

            $community->profile_picture = $fileName;
            $community->save();

            return redirect()->back()->with('success', 'Gambar profil komunitas anda berhasil diperbarui.');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->validator->errors())->withInput();
        }
    }

    public function updateBackgroundCover(Request $request, Community $community)
    {
        try {
            $request->validate([
                'background_cover' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $id = $community->id;

            $existingProfilePicture = $community->background_cover;
            if ($existingProfilePicture) {
                $filePath = "/img/communities/background_cover/$id/$existingProfilePicture";
                $fileFullPath = public_path($filePath);
                File::delete($fileFullPath);
            }

            $profilePicture = $request->file('background_cover');
            $fileName = time() . '.' . $profilePicture->getClientOriginalExtension();

            $directory = "/img/communities/background_cover/$id";
            if (!Storage::exists($directory)) {
                Storage::makeDirectory($directory);
            }

            $profilePicture->move(public_path($directory), $fileName);

            $community->background_cover = $fileName;
            $community->save();

            return redirect()->back()->with('success', 'Gambar background komunitas anda berhasil diperbarui.');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->validator->errors())->withInput();
        }
    }

    public function viewCreateCommunity(){
        return view('community.buatkomunitas', [
            "title" => 'Komunitas'
        ]);
    }

    public function createCommunity(Request $request){
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|regex:/^[a-zA-Z ]+$/',
            'deskripsi' => 'required|string|max:500',
            'social_media' => 'nullable|string',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'background_cover' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'nama.regex' => 'Nama Komunitas tidak boleh berupa angka/simbol',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $profilePicture = $request->file('profile_picture');
        if ($profilePicture){
            $profileImageFilename = time() . '.' . $profilePicture->getClientOriginalExtension();
        }

        $coverImage = $request->file('background_cover');
        if ($coverImage){
            $coverImageFilename = time() . '.' . $coverImage->getClientOriginalExtension();
        }


        $community = new Community();
        $community->name = $request->input('nama');
        $community->description = $request->input('deskripsi');
        $community->social_medias = $request->input('social_media');
        if ($profilePicture){
            $community->profile_picture = $profileImageFilename;
        }
        if ($coverImage){
            $community->background_cover = $coverImageFilename;
        }
        $community->save();

        $communityId = $community->getKey();

        if ($profilePicture){
            $profileDirectory = "/img/communities/profile_picture/$communityId";
            if (!Storage::exists($profileDirectory)) {
                Storage::makeDirectory($profileDirectory);
            }
            $profilePicture->move(public_path($profileDirectory), $profileImageFilename);
        }

        if($coverImage){
            $coverDirectory = "/img/communities/background_cover/$communityId";
            if (!Storage::exists($coverDirectory)) {
                Storage::makeDirectory($coverDirectory);
            }
            $coverImage->move(public_path($coverDirectory), $coverImageFilename);
        }

        $member = auth()->user()->member;

        $communityMember = new CommunityMember();
        $communityMember->member_id = $member->id;
        $communityMember->community_id = $communityId;
        $communityMember->membership_status = 'moderator';
        $communityMember->save();

        return redirect()->back()->with('success', 'Sukses! Komunitas baru telah dibuat!');
    }
}

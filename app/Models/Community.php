<?php

namespace App\Models;

use App\Traits\SearchableByName;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Community extends Model
{
    protected $guarded = ['id'];

    use HasFactory, SearchableByName;

    public function communitymembers()
    {
        return $this->hasMany(CommunityMember::class);
    }

    public function members()
    {
        return $this->hasManyThrough(Member::class, CommunityMember::class, 'community_id', 'id', 'id', 'member_id');
    }

    public function announcements()
    {
        return $this->hasMany(Announcement::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}

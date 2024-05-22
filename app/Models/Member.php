<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function books()
    {
        return $this->belongsToMany(Book::class)
            ->withTimestamps()
            ->withPivot('last_page', 'updated_at', 'created_at');
    }

    public function records()
    {
        return $this->hasMany(Record::class);
    }

    public function communities()
    {
        return $this->hasManyThrough(Community::class, CommunityMember::class, 'member_id', 'id', 'id', 'community_id');
    }

    public function communitymembers()
    {
        return $this->hasMany(CommunityMember::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}

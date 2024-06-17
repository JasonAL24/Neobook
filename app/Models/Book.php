<?php

namespace App\Models;

use App\Traits\SearchableByName;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory, SearchableByName;

    protected $guarded = ['id'];

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function members()
    {
        return $this->belongsToMany(Member::class)
            ->withTimestamps()
            ->withPivot('last_page', 'updated_at', 'created_at');
    }

    public function forumPosts()
    {
        return $this->hasMany(ForumPost::class);
    }

    public function record()
    {
        return $this->hasOne(Record::class);
    }
}

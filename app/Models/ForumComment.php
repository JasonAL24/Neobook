<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForumComment extends Model
{
    protected $guarded = ['id'];

    public function post()
    {
        return $this->belongsTo(ForumPost::class);
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function replies()
    {
        return $this->hasMany(ForumReply::class);
    }

    use HasFactory;
}

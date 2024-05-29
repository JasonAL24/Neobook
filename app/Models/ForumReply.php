<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForumReply extends Model
{
    use HasFactory;
    protected $guarded = ['id'];


    public function comment()
    {
        return $this->belongsTo(ForumComment::class);
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}

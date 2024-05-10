<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForumPost extends Model
{
    protected $guarded = ['id'];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    use HasFactory;
}

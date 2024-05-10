<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommunityMember extends Model
{
    protected $guarded = ['id'];

    public function community()
    {
        return $this->belongsTo(Community::class);
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    use HasFactory;
}

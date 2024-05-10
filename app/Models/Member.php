<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'member_name', 'member_address','member_profile_picture', 'member_phone'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

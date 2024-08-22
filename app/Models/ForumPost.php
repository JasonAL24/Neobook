<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForumPost extends Model
{
    /**
     * @var mixed
     */
    protected $guarded = ['id'];
    protected $fillable = ['member_id', 'book_id', 'title', 'content'];

    public function member()
    {
        // BelongsTo (One to One atau Many to One)
        return $this->belongsTo(Member::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function comments()
    {
        // HasMany (One to Many)
        return $this->hasMany(ForumComment::class);
    }
    use HasFactory;
}

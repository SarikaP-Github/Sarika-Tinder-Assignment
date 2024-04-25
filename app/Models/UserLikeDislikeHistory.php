<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLikeDislikeHistory extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function fromUserDetail()
    {
        return $this->belongsTo(User::class, 'like_from_user', 'id');
    }

    public function toUserDetail()
    {
        return $this->belongsTo(User::class, 'like_to_user', 'id');
    }
}

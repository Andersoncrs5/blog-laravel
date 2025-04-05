<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostLikesModel extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'post_likes';

    protected $fillable = [
        'id',
        'is_like',
        'user_id',
        'post_id',
    ];

    protected $casts = [];

    public function user()
    {
        return $this->belongsTo(UserModel::class);
    }

    public function post()
    {
        return $this->belongsTo(PostModel::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentLikesModel extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'comment_likes';

    protected $fillable = [
        'id',
        'is_like',
        'user_id',
        'comment_id',
    ];

    protected $casts = [];

    public function user()
    {
        return $this->belongsTo(UserModel::class);
    }

    public function comment()
    {
        return $this->belongsTo(CommentModel::class);
    }
}

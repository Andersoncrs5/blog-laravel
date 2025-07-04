<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    public function user(): BelongsTo
    {
        return $this->belongsTo(UserModel::class);
    }

    public function post(): BelongsTo
    {
        return $this->belongsTo(PostModel::class);
    }
}

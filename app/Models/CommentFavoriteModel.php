<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CommentFavoriteModel extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'comments_favorite';

    protected $fillable = [
        'id',
        'user_id',
        'comment_id',
    ];

    protected $casts = [];

    public function user(): BelongsTo
    {
        return $this->belongsTo(UserModel::class);
    }

    public function comment(): BelongsTo
    {
        return $this->belongsTo(CommentModel::class);
    }
}

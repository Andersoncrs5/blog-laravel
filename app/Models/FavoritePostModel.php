<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class FavoritePostModel extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'favorite_posts';

    protected $fillable = [
        'id',
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

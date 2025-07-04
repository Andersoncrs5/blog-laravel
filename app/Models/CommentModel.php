<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class CommentModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'comments';

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'content',
        'parent_id',
        'user_id',
        'post_id',
    ];

    protected $casts = [
        'id' => 'string',
        'parent_id' => 'string',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($comment) 
        {
            do 
            {
                $uuid = Str::uuid()->toString();
            } 
            while (self::where('id', $uuid)->exists());

            $comment->id = $uuid;
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(UserModel::class, 'user_id');
    }

    public function post(): BelongsTo
    {
        return $this->belongsTo(PostModel::class, 'post_id');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(CommentModel::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(CommentModel::class, 'parent_id');
    }

    public function comment_likes(): HasMany
    {
        return $this->hasMany(CommentLikesModel::class, 'comment_id', 'id');
    }

    public function comment_favorites(): HasMany
    {
        return $this->hasMany(CommentFavoriteModel::class, 'comment_id', 'id');
    }

}

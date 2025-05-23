<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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

    public function user()
    {
        return $this->belongsTo(UserModel::class, 'user_id');
    }

    public function post()
    {
        return $this->belongsTo(PostModel::class, 'post_id');
    }

    public function parent()
    {
        return $this->belongsTo(CommentModel::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(CommentModel::class, 'parent_id');
    }

    public function comment_likes()
    {
        return $this->hasMany(CommentLikesModel::class, 'comment_id', 'id');
    }

}

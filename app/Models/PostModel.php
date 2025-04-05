<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class PostModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'posts';

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'title',
        'content',
        'category_id',
        'viewed',
        'user_id',
    ];

    protected $casts = [
        'id' => 'string',
        'viewed' => 'integer',
    ];


    protected static function boot()
    {
        parent::boot();

        static::creating(function ($post) 
        {
            do 
            {
                $uuid = Str::uuid()->toString();
            } 
            while (self::where('id', $uuid)->exists());

            $post->id = $uuid;
        });
    }

    public function user()
    {
        return $this->belongsTo(UserModel::class);
    }

    public function category()
    {
        return $this->belongsTo(CategoryModel::class);
    }

    public function post_favorites()
    {
        return $this->hasMany(FavoritePostModel::class, 'post_id', 'id');
    }

    public function post_likes()
    {
        return $this->hasMany(PostLikesModel::class, 'post_id', 'id');
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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

    public function user()
    {
        return $this->belongsTo(UserModel::class);
    }

    public function post()
    {
        return $this->belongsTo(PostModel::class);
    }
}

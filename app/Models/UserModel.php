<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'id';

    protected $table = 'user';

    protected $fillable = ['name', 'email', 'password', 'is_adm'];

    protected $guarded = [];

    public $timestamps = true;

    public function comments() 
    {
        return $this->hasMany(CommentModel::class, 'user_id', 'id');
    }

    public function posts()
    {
        return $this->hasMany(PostModel::class, 'user_id', 'id');
    }

    public function post_favorites()
    {
        return $this->hasMany(FavoritePostModel::class, 'user_id', 'id');
    }

    public function followers()
    {
        return $this->hasMany(FollowersModel::class, 'followed_id', 'id');
    }

    public function following()
    {
        return $this->hasMany(FollowersModel::class, 'follower_id', 'id');
    }

    public function receivedNotifications()
    {
        return $this->hasMany(NotificationModel::class, 'user_id');
    }

    public function sentNotifications()
    {
        return $this->hasMany(NotificationModel::class, 'sender_id');
    }

    public function post_likes()
    {
        return $this->hasMany(PostLikesModel::class, 'user_id', 'id');
    }

    public function comment_likes()
    {
        return $this->hasMany(CommentLikesModel::class, 'user_id', 'id');
    }

    public function user_metric(): HasOne
    {
        return $this->hasOne(UserMetricModel::class);
    }

}

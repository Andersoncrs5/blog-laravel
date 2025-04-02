<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FollowersModel extends Model
{
    use HasFactory;

    protected $table = 'followers';

    public $timestamps = false;

    protected $fillable = ['follower_id', 'followed_id'];

    public function follower()
    {
        return $this->belongsTo(UserModel::class, 'follower_id');
    }

    public function followed()
    {
        return $this->belongsTo(UserModel::class, 'followed_id');
    }
}

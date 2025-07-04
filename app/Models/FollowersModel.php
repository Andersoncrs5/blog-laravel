<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FollowersModel extends Model
{
    use HasFactory;

    protected $table = 'followers';

    public $timestamps = false;

    protected $fillable = ['follower_id', 'followed_id'];

    public function follower(): BelongsTo
    {
        return $this->belongsTo(UserModel::class, 'follower_id');
    }

    public function followed(): BelongsTo
    {
        return $this->belongsTo(UserModel::class, 'followed_id');
    }
}

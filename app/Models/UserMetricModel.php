<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserMetricModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'id';

    protected $table = 'user';

    protected $fillable = [
        'likes_given_count_in_comment', 
        'dislikes_given_count_in_comment', 
        'likes_given_count_in_post', 
        'deslikes_given_count_in_post',
        'deslikes_given_count_in_post',
        'following_count',
        'following_count',
        'comments_count',
        'shares_count',
        'reports_received_count',
        'media_uploads_count',
        'saved_posts_count',
        'saved_comments_count',
        'saved_media_count',
        'edited_count',
        'play_list_count',
        'preference_count',
        'user_id'
    ];

    protected $guarded = [];

    public $timestamps = true;

    public function user(): BelongsTo 
    {
        return $this->belongsTo(UserModel::class);
    }
}

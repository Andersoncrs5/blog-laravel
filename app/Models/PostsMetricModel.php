<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class PostsMetricModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'id';

    protected $table = 'posts_metric';

    protected $fillable = [
        'post_id', 
        'likes', 
        'deslikes',
        'comments_count',
        'shares_count',
        'reports_received_count',
        'media_count',
        'favorite_count',
        'viewed_count',
        'reports_received_count',
        'edited_count',
    ];

    protected $guarded = [];

    public $timestamps = true;

    public function post(): BelongsTo 
    {
        return $this->belongsTo(PostModel::class);
    }
}

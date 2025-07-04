<?php

namespace App\Http\Services;

use App\Http\Controllers\PostController;
use App\Http\Services\enums\SumOrRed;
use App\Models\PostMetricModel;
use App\Models\PostsMetricModel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class PostMetricService 
{
    public static function get_metric(string $postId)
    {
        if (!$postId)
        {
            return redirect()->back()->with('error', 'id is required');
        }

        $metric = PostsMetricModel::where('post_id', $postId)->first();

        if ($metric == null)
        {
            return redirect()->back()->with('error', 'Error metric post not found!');
        }

        return $metric;
    }

    public static function create_metric(string $postId)
    {
        PostController::get($postId);
        
        if (!$postId)
        {
            return redirect()->back()->with('error', 'id is required');
        }

        PostsMetricModel::create(['post_id'=> $postId]);
    }

}
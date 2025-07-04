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

    public static function sum_or_red_like_count(PostsMetricModel $metric, SumOrRed $action)
    {
        try
        {
            DB::beginTransaction();

            if ($action == SumOrRed::SUM)
            {
                $metric->likes += 1;
            }

            if ($action == SumOrRed::RED)
            {
                $metric->likes -= 1;
            }

            $metric->save();

            DB::commit();
        }
        catch (\Throwable $th) 
        {
            DB::rollBack();
            return redirect()->route('index')->with('error', 'Error during sum or red metric post. Please try again later.');
        }
    }

    public static function sum_or_red_dislikes_count(PostsMetricModel $metric, SumOrRed $action)
    {
        try
        {
            DB::beginTransaction();

            if ($action == SumOrRed::SUM)
            {
                $metric->dislikes += 1;
            }

            if ($action == SumOrRed::RED)
            {
                $metric->dislikes -= 1;
            }

            $metric->save();

            DB::commit();
        }
        catch (\Throwable $th) 
        {
            DB::rollBack();
            return redirect()->route('index')->with('error', 'Error during sum or red metric post. Please try again later.');
        }
    }

    public static function sum_or_red_comments_count(PostsMetricModel $metric, SumOrRed $action)
    {
        try
        {
            DB::beginTransaction();

            if ($action == SumOrRed::SUM)
            {
                $metric->comments_count += 1;
            }

            if ($action == SumOrRed::RED)
            {
                $metric->comments_count -= 1;
            }

            $metric->save();

            DB::commit();
        }
        catch (\Throwable $th) 
        {
            DB::rollBack();
            return redirect()->route('index')->with('error', 'Error during sum or red metric post. Please try again later.');
        }
    }

    public static function sum_or_red_shares_count(PostsMetricModel $metric, SumOrRed $action)
    {
        try
        {
            DB::beginTransaction();

            if ($action == SumOrRed::SUM)
            {
                $metric->shares_count += 1;
            }

            if ($action == SumOrRed::RED)
            {
                $metric->shares_count -= 1;
            }

            $metric->save();

            DB::commit();
        }
        catch (\Throwable $th) 
        {
            DB::rollBack();
            return redirect()->route('index')->with('error', 'Error during sum or red metric post. Please try again later.');
        }
    }

    public static function sum_or_red_favorite_count(PostsMetricModel $metric, SumOrRed $action)
    {
        try
        {
            DB::beginTransaction();

            if ($action == SumOrRed::SUM)
            {
                $metric->favorite_count += 1;
            }

            if ($action == SumOrRed::RED)
            {
                $metric->favorite_count -= 1;
            }

            $metric->save();

            DB::commit();
        }
        catch (\Throwable $th) 
        {
            DB::rollBack();
            return redirect()->route('index')->with('error', 'Error during sum or red metric post. Please try again later.');
        }
    }

    public static function sum_or_red_viewed_count(PostsMetricModel $metric, SumOrRed $action)
    {
        try
        {
            DB::beginTransaction();

            if ($action == SumOrRed::SUM)
            {
                $metric->viewed_count += 1;
            }

            if ($action == SumOrRed::RED)
            {
                $metric->viewed_count -= 1;
            }

            $metric->save();

            DB::commit();
        }
        catch (\Throwable $th) 
        {
            DB::rollBack();
            return redirect()->route('index')->with('error', 'Error during sum or red metric post. Please try again later.');
        }
    }

    public static function sum_or_red_reports_received_count(PostsMetricModel $metric, SumOrRed $action)
    {
        try
        {
            DB::beginTransaction();

            if ($action == SumOrRed::SUM)
            {
                $metric->reports_received_count += 1;
            }

            if ($action == SumOrRed::RED)
            {
                $metric->reports_received_count -= 1;
            }

            $metric->save();

            DB::commit();
        }
        catch (\Throwable $th) 
        {
            DB::rollBack();
            return redirect()->route('index')->with('error', 'Error during sum or red metric post. Please try again later.');
        }
    }

    public static function sum_or_red_media_count(PostsMetricModel $metric, SumOrRed $action)
    {
        try
        {
            DB::beginTransaction();

            if ($action == SumOrRed::SUM)
            {
                $metric->media_count += 1;
            }

            if ($action == SumOrRed::RED)
            {
                $metric->media_count -= 1;
            }

            $metric->save();

            DB::commit();
        }
        catch (\Throwable $th) 
        {
            DB::rollBack();
            return redirect()->route('index')->with('error', 'Error during sum or red metric post. Please try again later.');
        }
    }

    public static function sum_or_red_edited_count(PostsMetricModel $metric, SumOrRed $action)
    {
        try
        {
            DB::beginTransaction();

            if ($action == SumOrRed::SUM)
            {
                $metric->edited_count += 1;
            }

            if ($action == SumOrRed::RED)
            {
                $metric->edited_count -= 1;
            }

            $metric->save();

            DB::commit();
        }
        catch (\Throwable $th) 
        {
            DB::rollBack();
            return redirect()->route('index')->with('error', 'Error during sum or red metric post. Please try again later.');
        }
    }
}
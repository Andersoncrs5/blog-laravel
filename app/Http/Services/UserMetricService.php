<?php

namespace App\Http\Services;

use App\Http\Services\enums\SumOrRed;
use App\Models\UserMetricModel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class UserMetricService 
{
    public static function get_metric(int $id): UserMetricModel | RedirectResponse
    {
        if (!$id || $id <= 0)
        {
            return redirect()->back()->with("error", "User id is required");
        }

        $metric = UserMetricModel::where('user_id', $id)->first();

        if ($metric == null)
        {
            return redirect()->back()->with("error", "User metric not found");
        }

        return $metric;
    }

    public static function create_metric(int $userId)
    {
        DB::beginTransaction();
        try
        {
            if (!$userId || $userId <= 0)
            {
                return redirect()->back()->with("error", "User id is required");
            }

            $metric = new UserMetricModel();
            $metric->user_id = $userId;

            $metric->save();
            DB::commit();
        }
        catch (\Throwable $th) 
        {
            die($th);
            DB::rollBack();
            return redirect()->back()->with("error", "Error the create user metric! Try again later");
        }
    }

    public static function sum_or_red_posts_count(UserMetricModel $metric, SumOrRed $action)
    {
        try
        {
            DB::beginTransaction();

            if ($action == SumOrRed::SUM)
            {
                $metric->posts_count += 1;
            }

            if ($action == SumOrRed::RED)
            {
                $metric->posts_count -= 1;
            }

            $metric->save();

            DB::commit();
        }
        catch (\Throwable $th) 
        {
            DB::rollBack();
            return redirect()->route('index')->with('error', 'Error during sum or red metric user. Please try again later.');
        }
    }

    public static function sum_or_red_comments_count(UserMetricModel $metric, SumOrRed $action)
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
            return redirect()->route('index')->with('error', 'Error during sum or red metric user. Please try again later.');
        }
    }

    public static function sum_or_red_shares_count(UserMetricModel $metric, SumOrRed $action)
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
            return redirect()->route('index')->with('error', 'Error during sum or red metric user. Please try again later.');
        }
    }

    public static function sum_or_red_reports_received_count(UserMetricModel $metric, SumOrRed $action)
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
            return redirect()->route('index')->with('error', 'Error during sum or red metric user. Please try again later.');
        }
    }

    public static function sum_or_red_media_uploads_count(UserMetricModel $metric, SumOrRed $action)
    {
        try
        {
            DB::beginTransaction();

            if ($action == SumOrRed::SUM)
            {
                $metric->media_uploads_count += 1;
            }

            if ($action == SumOrRed::RED)
            {
                $metric->media_uploads_count -= 1;
            }

            $metric->save();

            DB::commit();
        }
        catch (\Throwable $th) 
        {
            DB::rollBack();
            return redirect()->route('index')->with('error', 'Error during sum or red metric user. Please try again later.');
        }
    }

    public static function sum_or_red_saved_posts_count(UserMetricModel $metric, SumOrRed $action)
    {
        try
        {
            DB::beginTransaction();

            if ($action == SumOrRed::SUM)
            {
                $metric->saved_posts_count += 1;
            }

            if ($action == SumOrRed::RED)
            {
                $metric->saved_posts_count -= 1;
            }

            $metric->save();

            DB::commit();
        }
        catch (\Throwable $th) 
        {
            DB::rollBack();
            return redirect()->route('index')->with('error', 'Error during sum or red metric user. Please try again later.');
        }
    }

    public static function sum_or_red_saved_comments_count(UserMetricModel $metric, SumOrRed $action)
    {
        try
        {
            DB::beginTransaction();

            if ($action == SumOrRed::SUM)
            {
                $metric->saved_comments_count += 1;
            }

            if ($action == SumOrRed::RED)
            {
                $metric->saved_comments_count -= 1;
            }

            $metric->save();

            DB::commit();
        }
        catch (\Throwable $th) 
        {
            DB::rollBack();
            return redirect()->route('index')->with('error', 'Error during sum or red metric user. Please try again later.');
        }
    }

    public static function sum_or_red_saved_media_count(UserMetricModel $metric, SumOrRed $action)
    {
        try
        {
            DB::beginTransaction();

            if ($action == SumOrRed::SUM)
            {
                $metric->saved_media_count += 1;
            }

            if ($action == SumOrRed::RED)
            {
                $metric->saved_media_count -= 1;
            }

            $metric->save();

            DB::commit();
        }
        catch (\Throwable $th) 
        {
            DB::rollBack();
            return redirect()->route('index')->with('error', 'Error during sum or red metric user. Please try again later.');
        }
    }

    public static function sum_or_red_edited_count(UserMetricModel $metric, SumOrRed $action)
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
            return redirect()->route('index')->with('error', 'Error during sum or red metric user. Please try again later.');
        }
    }

    public static function sum_or_red_play_list_count(UserMetricModel $metric, SumOrRed $action)
    {
        try
        {
            DB::beginTransaction();

            if ($action == SumOrRed::SUM)
            {
                $metric->play_list_count += 1;
            }

            if ($action == SumOrRed::RED)
            {
                $metric->play_list_count -= 1;
            }

            $metric->save();

            DB::commit();
        }
        catch (\Throwable $th) 
        {
            DB::rollBack();
            return redirect()->route('index')->with('error', 'Error during sum or red metric user. Please try again later.');
        }
    }

    public static function sum_or_red_preference_count(UserMetricModel $metric, SumOrRed $action)
    {
        try
        {
            DB::beginTransaction();

            if ($action == SumOrRed::SUM)
            {
                $metric->preference_count += 1;
            }

            if ($action == SumOrRed::RED)
            {
                $metric->preference_count -= 1;
            }

            $metric->save();

            DB::commit();
        }
        catch (\Throwable $th) 
        {
            DB::rollBack();
            return redirect()->route('index')->with('error', 'Error during sum or red metric user. Please try again later.');
        }
    }

    public static function sum_or_red_likes_given_count_in_comment(UserMetricModel $metric, SumOrRed $action)
    {
        try
        {
            DB::beginTransaction();

            if ($action == SumOrRed::SUM)
            {
                $metric->likes_given_count_in_comment += 1;
            }

            if ($action == SumOrRed::RED)
            {
                $metric->likes_given_count_in_comment -= 1;
            }

            $metric->save();

            DB::commit();
        }
        catch (\Throwable $th) 
        {
            DB::rollBack();
            return redirect()->route('index')->with('error', 'Error during sum or red metric user. Please try again later.');
        }
    }

    public static function sum_or_red_dislikes_given_count_in_comment(UserMetricModel $metric, SumOrRed $action)
    {
        try
        {
            DB::beginTransaction();

            if ($action == SumOrRed::SUM)
            {
                $metric->dislikes_given_count_in_comment += 1;
            }

            if ($action == SumOrRed::RED)
            {
                $metric->dislikes_given_count_in_comment -= 1;
            }

            $metric->save();

            DB::commit();
        }
        catch (\Throwable $th) 
        {
            DB::rollBack();
            return redirect()->route('index')->with('error', 'Error during sum or red metric user. Please try again later.');
        }
    }

    public static function sum_or_red_likes_given_count_in_post(UserMetricModel $metric, SumOrRed $action)
    {
        try
        {
            DB::beginTransaction();

            if ($action == SumOrRed::SUM)
            {
                $metric->likes_given_count_in_post += 1;
            }

            if ($action == SumOrRed::RED)
            {
                $metric->likes_given_count_in_post -= 1;
            }

            $metric->save();

            DB::commit();
        }
        catch (\Throwable $th) 
        {
            DB::rollBack();
            return redirect()->route('index')->with('error', 'Error during sum or red metric user. Please try again later.');
        }
    }

    public static function sum_or_red_deslikes_given_count_in_post(UserMetricModel $metric, SumOrRed $action)
    {
        try
        {
            DB::beginTransaction();

            if ($action == SumOrRed::SUM)
            {
                $metric->deslikes_given_count_in_post += 1;
            }

            if ($action == SumOrRed::RED)
            {
                $metric->deslikes_given_count_in_post -= 1;
            }

            $metric->save();

            DB::commit();
        }
        catch (\Throwable $th) 
        {
            DB::rollBack();
            return redirect()->route('index')->with('error', 'Error during sum or red metric user. Please try again later.');
        }
    }

    public static function sum_or_red_followers_count(UserMetricModel $metric, SumOrRed $action)
    {
        try
        {
            DB::beginTransaction();

            if ($action == SumOrRed::SUM)
            {
                $metric->followers_count += 1;
            }

            if ($action == SumOrRed::RED)
            {
                $metric->followers_count -= 1;
            }

            $metric->save();

            DB::commit();
        }
        catch (\Throwable $th) 
        {
            DB::rollBack();
            return redirect()->route('index')->with('error', 'Error during sum or red metric user. Please try again later.');
        }
    }

    public static function sum_or_red_following_count(UserMetricModel $metric, SumOrRed $action)
    {
        try
        {
            DB::beginTransaction();

            if ($action == SumOrRed::SUM)
            {
                $metric->following_count += 1;
            }

            if ($action == SumOrRed::RED)
            {
                $metric->following_count -= 1;
            }

            $metric->save();

            DB::commit();
        }
        catch (\Throwable $th) 
        {
            DB::rollBack();
            return redirect()->route('index')->with('error', 'Error during sum or red metric user. Please try again later.');
        }
    }

}
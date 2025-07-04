<?php

namespace App\Http\Controllers;

use App\Http\Services\enums\SumOrRed;
use App\Http\Services\UserMetricService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\FollowersModel;
use App\Models\UserModel;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class FollowerController extends Controller 
{
    public function follow(int $id): RedirectResponse
    {
        try 
        {
            DB::transaction(function () use ($id) 
            { 
                $userId = session('id');

                if (!$userId) 
                {
                    throw new \Exception('Usuário não autenticado.'); 
                }

                if ($userId == $id) 
                {
                    return redirect()->back()->with('success', 'You cannot to follow yourself!!!');
                }

                if (FollowersModel::where('follower_id', $userId)->where('followed_id', $id)->exists()) 
                { 
                    return redirect()->back()->with('success', 'You already follow this user!');
                }

                FollowersModel::create([
                    'follower_id' => $userId,
                    'followed_id' => $id,
                ]);

                $followerMetric = UserMetricService::get_metric($userId);
                UserMetricService::sum_or_red_following_count($followerMetric, SumOrRed::SUM);

                $followedMetric = UserMetricService::get_metric($id);                
                UserMetricService::sum_or_red_followers_count($followedMetric, SumOrRed::SUM);
            });
            
            return redirect()->back()->with('success', 'Now you are following this user!');

        } 
        catch (\Throwable $e) 
        {   
            return redirect()->back()->with('error', 'Error the to follow the user!Please try again later');
        }
    }

    public function unfollow(int $id): RedirectResponse
    {
        try 
        {
            DB::transaction(function () use ($id) 
            { 
                $userId = session('id');

                $deleted = FollowersModel::where('follower_id', $userId)
                    ->where('followed_id', $id)
                    ->delete();

                if ($deleted) 
                {                    
                    $followerMetric = UserMetricService::get_metric($userId);
                    
                    UserMetricService::sum_or_red_following_count($followerMetric, SumOrRed::RED);
                    
                    $followedMetric = UserMetricService::get_metric($id);
                    
                    UserMetricService::sum_or_red_followers_count($followedMetric, SumOrRed::RED);
                } 
                else 
                {    
                    return redirect()->back()->with('success', 'You leted follow this user');
                }
            });

            return redirect()->back()->with('success', 'You not follow the user!');

        } 
        catch (\Throwable $e) 
        {
            return redirect()->back()->with('error', 'Erro ao deixar de seguir o usuário. Por favor, tente novamente.');
        }
    }

    public function followers(int $id): View
    {
        $user = UserModel::findOrFail($id);
        $followers = $user->followers()->with('follower')->paginate(50);

        return view('followers.index', compact('user', 'followers'));
    }

    public function following(int $id)
    {
        $user = UserModel::findOrFail($id);
        $following = $user->following()->with('followed')->paginate(50);

        return view('following.index', compact('user', 'following'));
    }
}
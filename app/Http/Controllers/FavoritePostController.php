<?php

namespace App\Http\Controllers;

use App\Http\Services\enums\SumOrRed;
use App\Http\Services\UserMetricService;
use App\Models\FavoritePostModel;
use App\Models\PostModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FavoritePostController extends Controller
{
    function save(string $id)
    {
        try
        {
            DB::beginTransaction();
            $data = [];

            $data['post_id'] = $id;
            $data['user_id'] = session('id');

            $check = $this->exists($id);

            if ($check)
            {
                return redirect()->route('post.getPost', ['id' => $id ] )->with('success', 'Post are already save!!!');
            }

            FavoritePostModel::create($data);

            DB::commit();
            $metric = UserMetricService::get_metric(session('id'));
            UserMetricService::sum_or_red_saved_posts_count($metric, SumOrRed::SUM);
            
            return redirect()->route('post.getPost', ['id' => $id ] )->with('success', 'Post saved!!!');
        }
        catch (\Exception $e)
        {
            DB::rollBack();
            return redirect()->route('post.getPost', ['id' => $id ] )->with('error', 'Error the save post!');
        }
    }

    public static function exists(string $postId)
    {
        try
        {
            if (!$postId)
            {
                return redirect()->route('post.getPost', ['id' => $postId ] )->with('success', 'Post saved!!!');
            }

            $check = FavoritePostModel::where('post_id', $postId)->where('user_id', session('id'))->first();

            if (!$check)
            {
                return false;
            }

            return true;
        }
        catch (\Exception $e)
        {
            return false;
        }
    }

    function remove(string $id)
    {
        try
        {
            DB::beginTransaction();
            $check = FavoritePostModel::where('post_id', $id)->where('user_id', session('id'))->first();

            if (!$check)
            {
                return redirect()->route('post.getPost', ['id' => $id ] )->with('error', 'Error the deleted post!!!');
            }

            $check->forceDelete();

            DB::commit();
            $metric = UserMetricService::get_metric(session('id'));
            UserMetricService::sum_or_red_saved_posts_count($metric, SumOrRed::RED);
            return redirect()->back()->with('success', 'Post removed!!!');
        }
        catch (\Exception $e)
        {
            DB::rollBack();
            return redirect()->route('post.getPost', ['id' => $id ] )->with('error', 'error the remove Post!!!');
        }
    }

    function PostFavoriteOfUser()
    {
        try 
        {
            $favorites = PostModel::select('posts.id', 'posts.title')
                ->join('favorite_posts', 'posts.id', '=', 'favorite_posts.post_id')
                ->where('favorite_posts.user_id', session('id'))
                ->paginate(50); 
    
            return view('favoritePost.get', ['posts' => $favorites]);
        } catch (\Exception $e) {
            return redirect()->route('index')->with('error', 'Error fetching favorite posts');
        }
    }

    function PostFavoriteOfAnotherUser(int $id)
    {
        try 
        {
            if ($id <= 0) 
            {
                return redirect()->back()->with('error', 'Id is required');
            }

            $favorites = PostModel::select('posts.id', 'posts.title')
                ->join('favorite_posts', 'posts.id', '=', 'favorite_posts.post_id')
                ->where('favorite_posts.user_id', $id)
                ->paginate(50); 
    
            return view('favoritePost.get', ['posts' => $favorites]);
        } catch (\Exception $e) {
            return redirect()->route('index')->with('error', 'Error fetching favorite posts');
        }
    }


}

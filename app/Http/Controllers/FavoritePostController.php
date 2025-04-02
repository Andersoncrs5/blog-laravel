<?php

namespace App\Http\Controllers;

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
            $data = [];

            $data['post_id'] = $id;
            $data['user_id'] = session('id');

            $check = $this->exists($id);

            if ($check)
            {
                return redirect()->route('post.getPost', ['id' => $id ] )->with('success', 'Post are already save!!!');
            }

            FavoritePostModel::create($data);

            return redirect()->route('post.getPost', ['id' => $id ] )->with('success', 'Post saved!!!');
        }
        catch (\Exception $e)
        {
            return redirect()->route('post.getPost', ['id' => $id ] )->with('error', 'Error the save post!');
        }
    }

    function exists(string $postId)
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

            $check = FavoritePostModel::where('post_id', $id)->where('user_id', session('id'))->first();

            if (!$check)
            {
                return redirect()->route('post.getPost', ['id' => $id ] )->with('error', 'Error the deleted post!!!');
            }

            $check->delete();

            return redirect()->back()->with('success', 'Post removed!!!');
        }
        catch (\Exception $e)
        {
            return redirect()->route('post.getPost', ['id' => $id ] )->with('error', 'error the remove Post!!!');
        }
    }

    function PostFavoriteOfUser()
    {
        try {
            $favorites = DB::select("
                SELECT p.id, p.title 
                FROM posts AS p
                INNER JOIN favorite_posts AS f ON p.id = f.post_id
                WHERE f.user_id = ?
            ", [session('id')]);

            return view('favoritePost.get', ['posts' => $favorites]);
        } catch (\Exception $e) {
            return redirect()->route('index')->with('error', 'Error fetching favorite posts');
        }
    }


}

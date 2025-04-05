<?php

namespace App\Http\Controllers;

use App\Models\PostLikesModel;
use App\Models\PostModel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostLikeController extends Controller
{
    public function get(string $postId): ?PostLikesModel
    {
        try 
        {
            if (!$postId) 
            {
                return null;
            }

            return PostLikesModel::where('user_id', session('id'))
                ->where('post_id', $postId)
                ->first();
        } 
        catch (\Throwable $th) 
        {
            
            return null;
        }
    }

    public function seeMyPostLike()
    {
        $posts = DB::select("
            SELECT p.* FROM posts AS p
            INNER JOIN post_likes AS l ON p.id = l.post_id
            WHERE l.user_id = ?
        ", [session('id')]);

        $posts = json_decode(json_encode($posts), true);

        return view('post.getAll', compact('posts'));
    }

    public function like(string $postId)
    {
        $postControl = new PostController();
        $post = $postControl->get($postId);

        $existingLike = $this->get($postId);

        if ($existingLike && $existingLike->is_like === true) 
        {
            return redirect()->back()->with('error', 'You already liked this post');
        }

        if ($existingLike) 
        {
            $existingLike->forceDelete();
        }

        PostLikesModel::create([
            'is_like' => true,
            'user_id' => session('id'),
            'post_id' => $postId,
        ]);

        return redirect()->back()->with('success', 'Post liked');
    }

    public function remover(string $postId)
    {
        try
        {
            $postControl = new PostController();
            $postControl->get($postId);
            $like = $this->get($postId);

            $like->forceDelete();

            return redirect()->back()->with('success', 'Like or unlike removed');
        }
        catch (\Throwable $th) 
        {
            return redirect()->back()->with('error', 'Error the to remove Like or unlike!!');
        }
    }

    public function unlike(string $postId)
    {
        $postControl = new PostController();
        $post = $postControl->get($postId);

        if (!$post) {
            return redirect()->back()->with('error', 'Post not found');
        }

        $existingLike = $this->get($postId);

        if ($existingLike && $existingLike->is_like === false) {
            return redirect()->back()->with('error', 'You already unliked this post');
        }

        if ($existingLike) {
            $existingLike->forceDelete();
        }

        PostLikesModel::create([
            'is_like' => false,
            'user_id' => session('id'),
            'post_id' => $postId,
        ]);

        return redirect()->back()->with('success', 'Post unliked');
    }

    public function countLikeByPost(string $postId)
    {
        try
        {
            $postControl = new PostController();

            $postControl->get($postId);

            $count = PostLikesModel::where('post_id', $postId)
                    ->where('is_like', true)->get()->count();

            return $count;
        }
        catch (\Throwable $th) 
        {
            return redirect()->back()->with('error', 'The count likes do post');
        }
    }

    public function countUnlikeByPost(string $postId)
    {
        try
        {
            $postControl = new PostController();

            $postControl->get($postId);

            $count = PostLikesModel::where('post_id', $postId)
                    ->where('is_like', false)->get()->count();

            return $count;
        }
        catch (\Throwable $th) 
        {
            return redirect()->back()->with('error', 'The count likes do post');
        }
    }

}

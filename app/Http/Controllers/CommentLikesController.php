<?php

namespace App\Http\Controllers;

use App\Models\CommentLikesModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommentLikesController extends Controller
{
    public function get(string $commentId): ?CommentLikesModel
    {
        try 
        {
            if (!$commentId) 
            {
                return null;
            }

            return CommentLikesModel::where('user_id', session('id'))
                ->where('comment_id', $commentId)
                ->first();
        } 
        catch (\Throwable $th) 
        {
            return null;
        }
    }

    public function seeMyCommentLike()
    {
        $comments = DB::select("
            SELECT c.* FROM comments AS c
            INNER JOIN comment_likes AS cl ON c.id = cl.comment_id
            WHERE cl.user_id = ?
        ", [session('id')]);

        $comments = json_decode(json_encode($comments), true);

        return view('comment.getAll', compact('comments'));
    }

    public function like(string $commentId)
    {
        $postControl = new PostController();
        $post = $postControl->get($commentId);

        $existingLike = $this->get($commentId);

        if ($existingLike && $existingLike->is_like === true) 
        {
            return redirect()->back()->with('error', 'You already liked this post');
        }

        if ($existingLike) 
        {
            $existingLike->forceDelete();
        }

        CommentLikesModel::create([
            'is_like' => true,
            'user_id' => session('id'),
            'comment_id' => $commentId,
        ]);

        return redirect()->back()->with('success', 'Post liked');
    }

    public function remover(string $commentId)
    {
        try
        {
            $postControl = new PostController();
            $postControl->get($commentId);
            $like = $this->get($commentId);

            $like->forceDelete();

            return redirect()->back()->with('success', 'Like or unlike removed');
        }
        catch (\Throwable $th) 
        {
            return redirect()->back()->with('error', 'Error the to remove Like or unlike!!');
        }
    }

    public function unlike(string $commentId)
    {
        $postControl = new PostController();
        $post = $postControl->get($commentId);

        if (!$post) {
            return redirect()->back()->with('error', 'Post not found');
        }

        $existingLike = $this->get($commentId);

        if ($existingLike && $existingLike->is_like === false) {
            return redirect()->back()->with('error', 'You already unliked this post');
        }

        if ($existingLike) {
            $existingLike->forceDelete();
        }

        CommentLikesModel::create([
            'is_like' => false,
            'user_id' => session('id'),
            'comment_id' => $commentId,
        ]);

        return redirect()->back()->with('success', 'Post unliked');
    }

    public function countLikeByComment(string $commentId)
    {
        try
        {
            $postControl = new PostController();

            $postControl->get($commentId);

            $count = CommentLikesModel::where('comment_id', $commentId)
                    ->where('is_like', true)->get()->count();

            return $count;
        }
        catch (\Throwable $th) 
        {
            return redirect()->back()->with('error', 'The count likes do post');
        }
    }

    public function countUnlikeByComment(string $commentId)
    {
        try
        {
            $postControl = new PostController();

            $postControl->get($commentId);

            $count = CommentLikesModel::where('comment_id', $commentId)
                    ->where('is_like', false)->get()->count();

            return $count;
        }
        catch (\Throwable $th) 
        {
            return redirect()->back()->with('error', 'The count likes do post');
        }
    }
}

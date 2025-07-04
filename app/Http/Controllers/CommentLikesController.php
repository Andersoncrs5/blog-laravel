<?php

namespace App\Http\Controllers;

use App\Http\Services\enums\SumOrRed;
use App\Http\Services\UserMetricService;
use App\Models\CommentLikesModel;
use App\Models\CommentModel;
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
        $comments = CommentModel::select('comments.*')
        ->join('comment_likes', 'comments.id', '=', 'comment_likes.comment_id')
        ->where('comment_likes.user_id', session('id'))
        ->paginate(50);

        return view('comment.getAll', compact('comments'));
    }

    public function seeCommentLike(int $id)
    {
        $comments = CommentModel::select('comments.*')
        ->join('comment_likes', 'comments.id', '=', 'comment_likes.comment_id')
        ->where('comment_likes.user_id', $id)
        ->paginate(50);

        return view('comment.getAll', compact('comments'));
    }

    public function like(string $commentId)
    {
        try
        {
            DB::beginTransaction();
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

            $metric = UserMetricService::get_metric(session('id'));
            UserMetricService::sum_or_red_likes_given_count_in_comment($metric, SumOrRed::SUM);

            DB::commit();
            return redirect()->back()->with('success', 'Post liked');
        }
        catch (\Throwable $th) 
        {
            DB::rollBack();
            return redirect()->back()->with('error', 'the give like in post');
        }
        
    }

    public function remover(string $commentId)
    {
        try
        {
            DB::beginTransaction();
            $postControl = new PostController();
            $postControl->get($commentId);
            $like = $this->get($commentId);

            $like->forceDelete();

            $metric = UserMetricService::get_metric(session('id'));

            if ($like->is_like == true)
            {
                UserMetricService::sum_or_red_likes_given_count_in_comment($metric, SumOrRed::RED);
            }
            else 
            {
                UserMetricService::sum_or_red_dislikes_given_count_in_comment($metric, SumOrRed::RED);
            }

            DB::commit();
            return redirect()->back()->with('success', 'Like or unlike removed');
        }
        catch (\Throwable $th) 
        {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error the to remove Like or unlike!!');
        }
    }

    public function unlike(string $commentId)
    {
        try
        {
            DB::beginTransaction();
            $postControl = new PostController();
            $post = $postControl->get($commentId);

            if (!$post) {
                return redirect()->back()->with('error', 'Post not found');
            }

            $existingLike = $this->get($commentId);

            if ($existingLike && $existingLike->is_like === false) {
                return redirect()->back()->with('error', 'You already unliked this post');
            }

            if ($existingLike) { $existingLike->forceDelete(); }
            
            $metric = UserMetricService::get_metric(session('id'));

            CommentLikesModel::create([
                'is_like' => false,
                'user_id' => session('id'),
                'comment_id' => $commentId,
            ]);

            UserMetricService::sum_or_red_dislikes_given_count_in_comment($metric, SumOrRed::RED);

            DB::commit();
            return redirect()->back()->with('success', 'Post unliked');
        }
        catch (\Throwable $th) 
        {
            DB::rollBack();
            return redirect()->back()->with('error', 'the give like in post');
        }
        
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

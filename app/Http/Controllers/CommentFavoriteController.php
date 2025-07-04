<?php

namespace App\Http\Controllers;

use App\Http\Services\enums\SumOrRed;
use App\Http\Services\UserMetricService;
use App\Models\CommentFavoriteModel;
use App\Models\CommentModel;
use App\Models\PostModel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommentFavoriteController extends Controller
{
    public function getAllCommentFavorite(int $userId)
    {
        $comments = CommentModel::select('comments.*')
                ->join('comments_favorite', 'comments.id', '=', 'comments_favorite.comment_id')
                ->where('comments_favorite.user_id', $userId)
                ->paginate(50); 

        return view('comment.commentsOfUser', compact('comments'));
    }

    public function save(string $id)
    {
        try
        {
            DB::beginTransaction();
            $data = [
                'user_id' => session('id'),
                'comment_id' => $id
            ];

            $check = $this->exists($id);

            if ($check)
            {
                return redirect()->back()->with('warn','Comment already are saved!');
            }
            
            CommentFavoriteModel::create($data);

            $metric = UserMetricService::get_metric(session('id'));
            UserMetricService::sum_or_red_saved_comments_count($metric, SumOrRed::SUM);

            DB::commit();
            return redirect()->route('comment.getComment', ['id' => $id ])->with('success','Comment saved!');
        }
        catch (\Throwable $th) 
        {
            DB::rollBack();
            return redirect()->back()->with('error','Error the to save comment how favorite');
        }
    }

    public function remove(string $id)
    {
        try
        {
            DB::beginTransaction();
            $check = $this->exists($id);

            if (!$check)
            {
                return redirect()->back()->with('warn','Comment not exists!');
            }
            
            $favorite = CommentFavoriteModel::where('comment_id', $id)->where('user_id', session('id'))->first();

            if (!$favorite)
            {
                return redirect()->back()->with('error','Favorite comment not found!');
            }

            $favorite->forceDelete();
            
            $metric = UserMetricService::get_metric(session('id'));
            UserMetricService::sum_or_red_saved_comments_count($metric, SumOrRed::RED);

            DB::commit();
            return redirect()->route('comment.getComment', ['id' => $id ])->with('success','Comment removed!');
        }
        catch (\Throwable $th) 
        {
            DB::rollBack();
            return redirect()->back()->with('error','Error the to remove comment how favorite');
        }
    }

    public static function exists(string $commentId): bool | RedirectResponse
    {
        try
        {
            if (!$commentId)
            {
                return redirect()->back()->with('error', 'Id is required!!!');
            }

            $check = CommentFavoriteModel::where('comment_id', $commentId)->where('user_id', session('id'))->first();

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

}

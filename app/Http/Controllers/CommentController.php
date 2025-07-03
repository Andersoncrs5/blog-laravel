<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentCreateOnCommentRequest;
use App\Http\Requests\CommentCreateRequest;
use App\Http\Requests\CommentUpdateRequest;
use App\Http\Services\enums\SumOrRed;
use App\Http\Services\UserMetricService;
use Illuminate\Http\Request;
use App\Models\CommentModel;
use Illuminate\Support\Facades\DB;

class CommentController extends Controller
{
    public function getAllCommentOfUser()
    {
        try
        {
            $user = UserController::get(session('id'));

            $comments = $user->comments()->paginate(50);

            return view('comment.commentsOfUser', compact('comments'));
        }
        catch (\Exception $e)
        {
            return redirect()->route('index')->with('error', 'Error');
        }
    }

    public function getAllCommentOfAnotherUser(int $id)
    {
        try
        {
            if ($id <= 0) { return redirect()->back()->with('error', 'Id is required'); }

            $user = UserController::get($id);

            $comments = $user->comments()->paginate(50);

            return view('comment.commentsOfUser', compact('comments'));
        }
        catch (\Exception $e)
        {
            return redirect()->route('index')->with('error', 'Error');
        }
    }

    public function createComment(string $id)
    {
        try
        {
            $post = PostController::get($id);

            return view('comment.create', compact('id'));
        }
        catch (\Exception $e)
        {
            return redirect()->route('index')->with('error', 'Error');
        }
    }

    public function creatingComment(CommentCreateRequest $r, string $id)
    {
        try
        {
            DB::beginTransaction();
            $post = PostController::get($id);

            $data = $r->all();

            $data['user_id'] = session('id');
            $data['post_id'] = $id;

            CommentModel::create($data);
            DB::commit();

            $metric = UserMetricService::get_metric(session('id'));
            UserMetricService::sum_or_red_comments_count($metric, SumOrRed::SUM);
            return redirect()->route('post.getPost', ['id' => $id ] )->with('success', 'Comment created with success !!!');
        }
        catch (\Exception $e)
        {
            DB::rollBack();
            return redirect()->route('index')->with('error', 'Error');
        }
    }

    public function get(string $id)
    {
        try
        {
            if(!$id)
            {
                return redirect()->back()->with('error', 'Id is required!!!');
            }

            $comment = CommentModel::find($id);

            if (!$comment)
            {
                return redirect()->back()->with('warning', 'Comment not found!!!');
            }

            return $comment;
        }
        catch (\Exception $e)
        {
            return redirect()->route('index')->with('error', 'Error');
        }
    }

    public function update(string $id)
    {
        try
        {
            $comment = $this->get($id);

            return view('comment.update', compact('comment'));
        }
        catch (\Exception $e)
        {
            return redirect()->route('index')->with('error', 'Error');
        }
    }

    public function updating(CommentUpdateRequest $r, string $id)
    {
        try
        {
            DB::beginTransaction();
            $comment = $this->get($id);

            $data = $r->all();

            $comment->update($data);

            DB::commit();
            return $this->getAllCommentOfUser()->with('success', 'Comment updated!!!');
        }
        catch (\Exception $e)
        {
            DB::rollBack();
            return redirect()->route('index')->with('error', 'Error');
        }
    }

    function delete(string $id)
    {
        try
        {
            DB::beginTransaction();
            $comment = $this->get($id);

            if ($comment->user_id != session('id'))
            {
                return redirect()->back()->with('error', 'This comment not are your!!');
            }

            $comment->delete();

            DB::commit();
            $metric = UserMetricService::get_metric(session('id'));
            UserMetricService::sum_or_red_comments_count($metric, SumOrRed::RED);
            return redirect()->route('comment.getAllCommentOfUser', ['id' => $id ])->with('success', 'Comment deleted!!!');
        }
        catch (\Exception $e)
        {
            DB::rollBack();
            return redirect()->route('index')->with('error', 'Error');
        }
    }

    public function getComment(string $id)
    {
        try
        {
            $comment = $this->get($id);

            $commentsOfComment = CommentModel::where('parent_id', $id)->paginate(50);

            $likeController = new CommentLikesController();
            $res = $likeController->get($id); 

            $like = $likeController->countLikeByComment($id);
            $unlike = $likeController->countUnlikeByComment($id);

            return view('comment.get', compact(
                'comment', 'commentsOfComment',
                'res', 'like', 'unlike'
            ));
        }
        catch (\Exception $e)
        {
            return redirect()->route('index')->with('error', 'Error');
        }
    }

    public function commentOnComment(string $id) 
    {
        try
        {
            $comment = $this->get($id);

            return view('comment.commentOnComment', compact('comment'));
        }
        catch (\Exception $e)
        {
            return redirect()->route('index')->with('error', 'Error');
        }
    }

    public function commentingOnComment(string $id, CommentCreateOnCommentRequest $r) 
    {
        try
        {
            DB::beginTransaction();
            $data = $r->all();

            $data['parent_id'] = $id;
            $data['user_id'] = session('id');

            CommentModel::create($data);

            DB::commit();
            return $this->getComment($id)->with('success','Comment created!!');
        }
        catch (\Exception $e)
        {
            DB::rollBack();
            return redirect()->route('index')->with('error', 'Error');
        }
    }

}
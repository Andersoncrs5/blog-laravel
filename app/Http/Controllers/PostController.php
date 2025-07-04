<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostCreateRequest;
use App\Http\Requests\PostSearchRequest;
use App\Http\Requests\PostUpdateRequest;
use App\Http\Services\enums\SumOrRed;
use App\Http\Services\PostMetricService;
use App\Http\Services\UserMetricService;
use App\Models\CategoryModel;
use App\Models\CommentModel;
use App\Models\FollowersModel;
use App\Models\PostModel;
use App\Models\UserModel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    public function searchByTitle(PostSearchRequest $request)
    {
        try 
        {
            $title = $request->query('title');

            $posts = PostModel::where('title', 'LIKE', "%{$title}%")->get()->toArray();

            // return view('post.getAll', compact('posts'));
        } 
        catch (\Throwable $th)
        {
            return redirect()->route('index')->with('error', 'Error searching posts');
        }
    }

    function save()
    {
        try
        {
            $categories = CategoryModel::where('is_active', true)->get()->toArray();
            return view('post.save', compact('categories'));
        }
        catch (\Throwable $th)
        {
            return redirect()->route('index')->with('error', 'Error loading save page');
        }
    }

    public function saving(PostCreateRequest $r): RedirectResponse
    {
        try 
        {            
            DB::beginTransaction();

            $data = $r->validated();

            $userId = session('id');

            $data['user_id'] = $userId;

            $postCreated = PostModel::create($data);                 
            
            $metric = UserMetricService::get_metric($userId);
            UserMetricService::sum_or_red_posts_count($metric, SumOrRed::SUM);

            PostMetricService::create_metric($postCreated->id);

            DB::commit();
            return redirect()->route('index')->with('success', 'Post criado com sucesso!!!');

        } 
        catch (\Throwable $th) 
        {
            echo '<pre>';
            print_r($th);
            die();
            DB::rollBack();
            return redirect()->route('index')->with('error', 'Erro ao salvar o post. Por favor, tente novamente mais tarde.');
        }
    }

    public function getAllOfUser()
    {
        try
        {
            $user = UserModel::find(session('id'));

            $posts = PostModel::where('user_id', session('id'))->paginate(50);

            return view('post.getAllOfUser', compact('posts'));
        }
        catch (\Throwable $th)
        {
            return redirect()->route('index')->with('error', 'Error loading create page');
        }
    }

    public function getAllOfAnotherUser(int $id)
    {
        try
        {
            $user = UserModel::find($id);

            if ($user == null){ return redirect()->back()->with('error', 'User not found'); }

            $posts = PostModel::where('user_id', session('id'))->paginate(50);

            return view('post.getAllOfUser', compact('posts'));
        }
        catch (\Throwable $th)
        {
            return redirect()->route('index')->with('error', 'Error loading create page');
        }
    }

    public function getByCategory(int $category_id)
    {
        try
        {
            $posts = PostModel::where('category_id',$category_id)->paginate(50);

            return view('post.getAll', compact('posts'));
        }
        catch (\Throwable $th)
        {
            return redirect()->route('index')->with('error', 'Error loading create page');
        }
    }

    public static function get(string $id)
    {
        try
        {
            if (!$id)
            {
                return redirect()->back()->with('error', 'id is required');
            }

            $post = PostModel::where('id', $id)->first();

            if (!$post)
            {
                return redirect()->back()->with('error', 'Post not found');
            }

            return $post;
        }
        catch (\Throwable $th)
        {
            return redirect()->route('index')->with('error', 'Error the get the post');
        }
    }

    public function getPost(string $id)
    {
        try
        {
            $post = $this->get($id);
            
            $metric_post = PostMetricService::get_metric($id);
            PostMetricService::sum_or_red_viewed_count($metric_post, SumOrRed::SUM);

            $check = FavoritePostController::exists($id);

            $comments = CommentModel::where('post_id', $id)->where('parent_id', null)->get();

            $likeController = new PostLikeController();
            $res = $likeController->get($id); 

            $like = $likeController->countLikeByPost($id);
            $unlike = $likeController->countUnlikeByPost($id);

            return view('post.get', compact(
                'post','comments', 'check', 
                'res', 'like', 'unlike'
            ));
        }
        catch (\Throwable $th)
        {
            die($th);
            return redirect()->route('index')->with('error', 'Error the get the post');
        }
    }

    public function update(string $id)
    {
        try
        {
            $post = $this->get($id);

            if ($post->user_id != session('id'))
            {
                return redirect()->back()->with('error', 'This post are not your!!');
            }

            return view('post.update', compact('post'));
        }
        catch (\Throwable $th)
        {
            return redirect()->route('index')->with('error', 'Error loading create page');
        }
    }

    public function updating(PostUpdateRequest $r)
    {
        try
        {
            DB::transaction();

            $data = $r->all();
            $post = $this->get($data['id']);

            if ($post->user_id != session('id'))
            {
                return redirect()->back()->with('error', 'This post are not your!!');
            }

            $post->update($data);

            DB::commit();

            $metric_post = PostMetricService::get_metric($post->id);
            PostMetricService::sum_or_red_edited_count($metric_post, SumOrRed::SUM);

            return redirect()->route('post.getAllOfUser')->with('success', 'Post updated!!!');
        }
        catch (\Throwable $th)
        {
            DB::rollBack();
            return redirect()->route('index')->with('error', 'Error loading create page');
        }
    }

    public function delete(string $id)
    {
        try
        {
            DB::beginTransaction();
            $post = $this->get($id);

            if ($post->user_id != session('id'))
            {
                return redirect()->back()->with('error', 'This post are not your!!');
            }

            $post->delete();

            DB::commit();
            $metric = UserMetricService::get_metric(session('id'));
            UserMetricService::sum_or_red_posts_count($metric, SumOrRed::RED);
            return redirect()->route('post.getAllOfUser')->with('success', 'Post deleted!!!');
        }
        catch (\Throwable $th)
        {
            DB::rollBack();
            return redirect()->route('index')->with('error', 'Error loading create page');
        }
    }

    public function creater(int $id) 
    {
        try
        {
            $user = UserModel::find($id);

            if (!$user)
            {
                return redirect()->back()->with('warning', 'User not found!!!');
            }

            $totalFollowers = FollowersModel::where('followed_id', session('id'))->count();

            $check = FollowersModel::where('follower_id', session('id'))->where('followed_id', $id)->exists();

            return view('post.creater', compact('user','totalFollowers', 'check'));
        }
        catch (\Throwable $th)
        {
            return redirect()->route('index')->with('error', 'Error loading create page');
        }
    }

    public function seePostOfUser(int $id)
    {
        try
        {
            $user = UserModel::find($id);

            if (!$user)
            {
                return redirect()->back()->with('warning', 'User not found!!!');
            }

            $posts = PostModel::where('user_id', $id)->get()->paginate(50);

            return view('post.showPost', compact('posts'));
        }
        catch (\Throwable $th)
        {
            return redirect()->route('index')->with('error', 'Error loading create page');
        }
    }

}

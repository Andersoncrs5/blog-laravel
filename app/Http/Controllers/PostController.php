<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostCreatehRequest;
use App\Http\Requests\PostSearchRequest;
use App\Http\Requests\PostUpdateRequest;
use App\Models\CategoryModel;
use App\Models\CommentModel;
use App\Models\FollowersModel;
use App\Models\PostModel;
use App\Models\UserModel;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function searchByTitle(PostSearchRequest $request)
    {
        try 
        {
            $title = $request->query('title');

            $posts = PostModel::where('title', 'LIKE', "%{$title}%")->get()->toArray();

            return view('post.getAll', compact('posts'));
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

    public function saving(PostCreatehRequest $r)
    {
        try
        {
            $data = $r->all();

            $data['user_id'] = session('id');

            PostModel::create($data);
            return redirect()->route('index')->with('success', 'Post created with success!!!');
        }
        catch (\Throwable $th)
        {
            return redirect()->route('index')->with('error', 'Error loading save page');
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

    public function get(string $id)
    {
        try
        {
            if (!$id)
            {
                return redirect()->back()->with('error', 'id is required');
            }

            $post = PostModel::find($id);

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

            $post->viewed += 1;
            $post->save();

            $favoritePostController = new FavoritePostController();

            $check = $favoritePostController->exists($id);

            $comments = CommentModel::where('post_id', $id)->where('parent_id', null)->get();

            $likeController = new PostLikeController();
            $res = $likeController->get($id); 

            $like = $likeController->countLikeByPost($id);
            $unlike = $likeController->countUnlikeByPost($id);

            return view('post.get', compact('post',
                 'comments', 'check', 'res',
                 'like', 'unlike'
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
            $data = $r->all();
            $post = $this->get($data['id']);

            if ($post->user_id != session('id'))
            {
                return redirect()->back()->with('error', 'This post are not your!!');
            }

            $post->update($data);

            return redirect()->route('post.getAllOfUser')->with('success', 'Post updated!!!');
        }
        catch (\Throwable $th)
        {
            return redirect()->route('index')->with('error', 'Error loading create page');
        }
    }

    public function delete(string $id)
    {
        try
        {
            $post = $this->get($id);

            if ($post->user_id != session('id'))
            {
                return redirect()->back()->with('error', 'This post are not your!!');
            }

            $post->delete();

            return redirect()->route('post.getAllOfUser')->with('success', 'Post deleted!!!');
        }
        catch (\Throwable $th)
        {
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

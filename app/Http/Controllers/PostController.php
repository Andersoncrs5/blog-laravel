<?php

namespace App\Http\Controllers;

use App\Models\CategoryModel;
use App\Models\PostModel;
use App\Models\UserModel;
use Illuminate\Http\Request;

class PostController extends Controller
{
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

    public function saving(Request $r)
    {
        try
        {
            $data = $r->all();

            $data['user_id'] = session('id');



            echo '<pre>';
            print_r($data);
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

            $posts = $user->posts->toArray();

            echo "<pre>";
            print_r($posts);
        }
        catch (\Throwable $th)
        {
            return redirect()->route('index')->with('error', 'Error loading create page');
        }
    }

    public function getByCategory(string $category)
    {
        try
        {
            echo $category;
        }
        catch (\Throwable $th)
        {
            return redirect()->route('index')->with('error', 'Error loading create page');
        }
    }

    

}

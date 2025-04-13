<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryCreateRequest;
use App\Http\Requests\CategoryUpdateRequest;
use App\Models\CategoryModel;
use App\Models\UserModel;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    private $userController;

    public function __construct(UserController $userController)
    {
        $this->userController = $userController;
    }

    private function get(int $id)
    {
        try
        {
            if (!$id || $id <= 0)
            {
                return redirect()->back()->with('error', 'Id is required');
            }

            $category = CategoryModel::find($id);

            if (!$category)
            {
                return redirect()->back()->with('warning', 'Category not found');
            }

            return $category;
        }
        catch (\Exception $e)
        {
            return redirect()->route('index')->with('error', 'Error the search category');
        }
    }

    private function checkName($name)
    {
        try
        {
            if (!$name)
            {
                return redirect()->back()->with('warning', 'Name is required!');
            }
            $check = CategoryModel::where("name", $name)->first();

            if ($check) {
                return redirect()->back()->with('warning', 'Name unavailable!');
            }
        }
        catch (\Exception $e)
        {
            return redirect()->route('index')->with('error', 'Error the search category');
        }
    }

    public function getAll()
    {
        try
        {
            $categories = CategoryModel::where('is_active', true)->get()->toArray();
            return $categories;
        }
        catch (\Throwable $th)
        {
            return redirect()->route('index')->with('error', 'Error loading all category!');
        }
    }

    public function getAllToAdm()
    {
        try
        {
            $categories = CategoryModel::paginate(20);
            return view('category.getAll', compact('categories'));
        }
        catch (\Throwable $th)
        {
            die($th);
            return redirect()->route('index')->with('error', 'Error loading all category!');
        }
    }

    public function save()
    {
        try
        {
            return view('category.create');
        }
        catch (\Throwable $th)
        {
            return redirect()->route('index')->with('error', 'Error loading all category!');
        }
    }

    public function saving(CategoryCreateRequest $r)
    {
        try
        {
            $data = $r->all();

            $this->checkName($data['name']);

            $data['user_id'] = session("id");

            CategoryModel::create($data);
            return redirect()->route('index')->with('success', 'Category created!');
        }
        catch (\Exception $e)
        {
            return redirect()->route('index')->with('error', 'Error the create category! try again later');
        }
    }

    public function update(int $id)
    {
        try
        {
            $category = $this->get($id);
            return view('category.update', compact('category'));
        }
        catch (\Throwable $t)
        {
            return redirect()->route('index')->with('error', 'Error loading all category!');
        }
    }

    public function confirmDelete(int $id)
    {
        try
        {
            $category = $this->get($id);

            $category->delete();

            return redirect()->route('category.getAllToAdm')->with('success', 'Category deleted!');
        }
        catch (\Throwable $t)
        {
            return redirect()->route('index')->with('error', 'Error to delete category!');
        }
    }

    public function seeCreater(int $id)
    {
        try
        {
            $user = $this->userController->get($id)->toArray();

            print_r($user);
        }
        catch (\Throwable $t)
        {
            return redirect()->route('index')->with('error', 'Error to delete category!');
        }
    }

    public function updating(CategoryUpdateRequest $r)
    {
        try
        {
            $data = $r->all();

            $category = $this->get($data['id']);

            $this->checkName($data['name']);

            $category->update($data);
            return redirect()->route('category.getAllToAdm')->with('success', 'Category updated!');
        }
        catch (\Exception $e)
        {
            return redirect()->route('category.getAllToAdm')->with('error', 'Error the update category');
        }
    }

    public function changeStatus(int $id)
    {
        try
        {
            $category = $this->get($id);
            $category->is_active = !$category->is_active;
            $category->save();

            return redirect()->route('category.getAllToAdm')->with('success', 'Category status changed!');
        }
        catch (\Throwable $t)
        {
            return redirect()->route('index')->with('error', 'Error the change status of category!');
        }
    }

}




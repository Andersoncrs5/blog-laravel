<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Services\UserMetricService;
use App\Models\CategoryModel;
use App\Models\FollowersModel;
use App\Models\NotificationModel;
use App\Models\PostModel;
use App\Models\UserModel;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

use function Psy\debug;

class UserController extends Controller
{
    public function index()
    {
        try
        {
            $posts = PostModel::orderBy('created_at', 'desc')->paginate(200);
            $categories = CategoryModel::where('is_active', true)->get()->toArray();
            return view('home', compact('categories', 'posts'));
        }
        catch (\Throwable $th)
        {
            echo $th;
        }
    }

    function login() : View | RedirectResponse
    {
        try
        {
            return view('user.login');
        }
        catch (\Exception $e)
        {
            return redirect()->route('index')->with('error', 'Error loading login page');
        }
    }

    function logining(UserLoginRequest $r) : RedirectResponse
    {
        try
        {
            $data = $r->all();

            $data['email'] = trim($data['email']);
            $data['password'] = trim($data['password']);

            $user = UserModel::where('email', $data['email'])->first();

            if (!$user)
            {
                return redirect()->route('login')->with('warning', 'Invalid login credentials!');
            }

            if(!Hash::check($data['password'], $user->password))
            {
                return redirect()->route('login')->with('warning', 'Invalid login credentials!');
            }

            session()->put('id', $user->id);
            session()->put('email', $user->email);
            session()->put('active', true);
            session()->put('is_adm', $user->is_adm);

            return redirect()->route('index')->with('success', "Welcome again $user->name!");
        }
        catch (\Exception $e)
        {
            return redirect()->route('index')->with('error', 'Error during login. Please try again later.');
        }
    }

    function register() : View | RedirectResponse
    {
        try
        {
            return view('user.register');
        } catch (\Exception $e) {
            return redirect()->route('index')->with('error', 'Error loading registration page');
        }
    }

    function registering(UserRegisterRequest $r) : RedirectResponse
    {
        DB::beginTransaction();

        try
        {
            $data = $r->all();

            $data['email'] = trim($data['email']);
            $data['password'] = trim(Hash::make($data['password']));

            $checkEmail = UserModel::where('email', $data['email'])->first();

            if ($checkEmail) {
                return redirect()->route('register')->with('warning', 'Email is already in use!');
            }

            UserModel::create($data);

            $user = UserModel::where('email', $data['email'])->first();

            session()->put('id', $user->id);
            session()->put('email', $user->email);
            session()->put('active', true);
            session()->put('is_adm', $user->is_adm);

            UserMetricService::create_metric($user->id);

            DB::commit();
            return redirect()->route('index')->with('success', "Registration successful! Welcome $user->name!");
        }
        catch (\Exception $e)
        {
            DB::rollBack();
            return redirect()->route('index')->with('error', 'Error during registration. Please try again later.');
        }
    }

    function profile(): View | RedirectResponse
    {
        try
        {
            $user = UserModel::find(session('id'));

            $totalFollowers = FollowersModel::where('followed_id', session('id'))->count();
            $totalFolloweds = FollowersModel::where('follower_id', session('id'))->count();

            return view("user.profile", compact('user','totalFollowers', 'totalFolloweds'));
        }
        catch (\Exception $e)
        {
            return redirect()->route('index')->with('error', 'Error during profile page loading');
        }
    }

    function delete()
    {
        try
        {
            DB::beginTransaction();

            $user = $this->get(session('id'));

            $user->forceDelete();
            DB::commit();

            return redirect()->route('index')->with('success', 'User deleted!!!');
        } 
        catch (\Exception $e) 
        {
            DB::rollBack();
            return redirect()->route('index')->with('error', 'Error loading registration page');
        }
    }

    public function logout() : RedirectResponse
    {
        try {
            session()->flush();
            return redirect()->route('index')->with('success', 'Bye Bye!');
        } catch (\Exception $e) {
            return redirect()->route('index')->with('error', 'An error occurred during logout!');
        }
    }

    function deleteUser()
    {
        try
        {
            DB::beginTransaction();

            $user = $this->get(session('id'));

            $user->forceDelete();
            DB::commit();

            return redirect()->route('index')->with('success', 'User deleted!!!');
        } 
        catch (\Exception $e) 
        {
            DB::rollBack();
            return redirect()->route('index')->with('error', 'Error loading registration page');
        }
    }

    function updateUser(): RedirectResponse|View
    {
        try
        {
            $user = UserModel::find(session('id'));

            return view("user.update", compact('user'));
        } catch (\Exception $e) {
            return redirect()->route('index')->with('error', 'Error loading update page');
        }
    }

    function updatingUser(UserUpdateRequest $r): RedirectResponse
    {
        try
        {
            DB::beginTransaction();
            $data = $r->all();

            $data['email'] = session('email');
            $data['password'] = Hash::make($data['password']);

            $user = UserModel::find(session('id'));

            $user->update($data);

            DB::commit();
            return redirect()->route('index')->with('success', 'Update successful!');
        }
        catch (\Exception $e)
        {
            DB::rollBack();
            return redirect()->route('index')->with('error', 'Error during the update. Please try again later.');
        }
    }

    public function get(int $id)
    {
        try
        {
            $user = UserModel::find($id);

            if (!$user)
            {
                return redirect()->back()->with('warning', 'User not found');
            }

            return $user;
        }
        catch (\Throwable $th)
        {
            return redirect()->back()->with('error', 'Error the search user');
        }
    }

    public function followers()
    {
        try {    
            $followers = DB::select("
                SELECT u.id, u.name
                FROM users AS u
                INNER JOIN followers AS f ON u.id = f.follower_id
                WHERE f.followed_id = ?
            ", [session('id')]);
    
            return view('user.follower', compact('followers'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error fetching followers');
        }
    }

    public function following()
    {
        try 
        {
            $user = $this->get(session('id'));

            $fs = $user->following()->get()->toArray();

            $followers = [];

            foreach ($fs as $f) {
                $d = UserModel::find($f['id'])->toArray();
                array_push($followers, $d);
            }

            return view('user.follower', compact('followers'));
        } 
        catch (\Throwable $th) 
        {
            return redirect()->back()->with('error', 'Error the search your followers');
        }
    }

    public function seeSentNotificationsByMe()
    {
        try 
        {
            $user = UserModel::find(session('id'));

            if ($user->is_adm == false ) {
                return redirect()->back()->with('error', 'You do not have permission to access this page!');
            }


            $nots = NotificationModel::where('user_id', session('id'))->paginate(20);

            return view('notification.getAll', compact('nots'));
        } 
        catch (\Throwable $th) 
        {
            return redirect()->back()->with('error', 'Error the search your notifications');
        }
    }

}


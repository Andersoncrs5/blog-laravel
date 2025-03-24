<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
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

    function logining(Request $r) : RedirectResponse
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

            return redirect()->route('index')->with('success', 'Welcome again!');
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

    function registering(Request $r) : RedirectResponse
    {
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

            return redirect()->route('index')->with('success', 'Registration successful! Welcome!');
        }
        catch (\Exception $e)
        {
            return redirect()->route('index')->with('error', 'Error during registration. Please try again later.');
        }
    }

    function profile(): View | RedirectResponse
    {
        try
        {
            $user = UserModel::find(session('id'));

            return view("user.profile", compact('user'));
        }
        catch (\Exception $e)
        {
            return redirect()->route('index')->with('error', 'Error during profile page loading');
        }
    }

    function delete()
    {
        try {
            echo "Inside delete operation";
            //return redirect()->route('index')->with('msg', 'done!');
        } catch (\Exception $e) {
            return redirect()->route('index')->with('error', 'Error during delete operation');
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
            echo "dentro de deleteUser";
            //return view('user.register');
        } catch (\Exception $e) {
            return redirect()->route('index')->with('error', 'Error loading registration page');
        }
    }

    function updateUser()
    {
        try
        {
            $user = UserModel::find(session('id'));

            return view("user.update", compact('user'));
        } catch (\Exception $e) {
            return redirect()->route('index')->with('error', 'Error loading update page');
        }
    }

    function updatingUser(Request $r)
    {
        try
        {
            $data = $r->all();


            $data['email'] = session('email');
            $data['password'] = Hash::make($data['password']);

            $user = UserModel::find(session('id'));

            $user->update($data);

            return redirect()->route('index')->with('success', 'Update successful!');
        }
        catch (\Exception $e)
        {
            return redirect()->route('index')->with('error', 'Error during the update. Please try again later.');
        }
    }

}


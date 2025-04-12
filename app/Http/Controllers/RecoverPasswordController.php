<?php

namespace App\Http\Controllers;

use App\Http\Requests\RecoverCheckEmailRequest;
use App\Http\Requests\RecoverCheckTokenRequest;
use App\Http\Requests\RecoverResetRequest;
use App\Mail\RecoverPasswordMail;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Models\UserModel;
use App\Models\RecoverPasswordModel;

class RecoverPasswordController extends Controller
{
    public function requestForm()
    {
        try
        {
            return view('recoverPassword.requestForm');
        }
        catch (\Throwable $th) 
        {
            die($th);
        }
    }

    public function findUserByEmail(string $email)
    {
        $user = UserModel::where('email', $email)->first();

        if ($user == null) 
        {
            return redirect()->back()->with('error', 'User not found');
        }


        return $user;
    }

    public function checkEmail(RecoverCheckEmailRequest $r)
    {
        try {
            $data = $r->all();
            $user = $this->findUserByEmail($data['email']);

            $email = $user->email;
            $token = Str::random(128);

            RecoverPasswordModel::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'email' => $email,
                    'token' => $token,
                    'status' => 'pending',
                    'expire_at' => now()->addMinutes(30),
                ]
            );

            $recover = RecoverPasswordModel::where('user_id', $user->id)->first();

            if (!$recover) {
                return redirect()->back()->with('error', 'Erro ao buscar o token');
            }

            Mail::to($email)->send(new RecoverPasswordMail($user, $recover));

            return view('recoverPassword.checkToken', compact('email'));
        } catch (\Throwable $th) {
            die($th);
        }
    }

    public function checkToken(string $email, RecoverCheckTokenRequest $r)
    {
        try
        {
            $data = $r->all();

            $recover = RecoverPasswordModel::where('email', $email)->first();

            if ($recover == null)
            {
                return redirect()->back()->with('error', 'Recover not found');
            }

            if (now()->greaterThan($recover->expire_at))
            {
                return redirect()->back()->with('error', 'Date expired!!');
            }
            
            if ($recover->token != $data['token'] )
            {
                return redirect()->back()->with('error', 'Token invalid');
            }

            session()->put('emailToReset', $email);

            return view('recoverPassword.reset');
        }
        catch (\Throwable $th) 
        {
            die($th);
        }
    }

    public function reset(RecoverResetRequest $r)
    {
        try
        {
            $data = $r->all();

            $email = session('emailToReset');

            $user = $this->findUserByEmail($email);

            $data['password'] = Hash::make($data['password']);

            $user->password = $data['password']; 

            $user->update($user);

            session()->forget('emailToReset');

            session()->put('id', $user->id);
            session()->put('email', $user->email);
            session()->put('active', true);
            session()->put('is_adm', $user->is_adm);

            return redirect()->route('index')->with('success', "Passoword updated $user->name!");
        }
        catch (\Throwable $th) 
        {
            die($th);
        }
    }

}
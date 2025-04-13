<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\FollowersModel;
use App\Models\UserModel;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class FollowerController extends Controller
{
    public function follow(int $id): RedirectResponse
    {
        try 
        {
            DB::transaction();
            $userId = session('id');

            if ($userId == $id) 
            {
                return redirect()->back()->with('error', 'Você não pode seguir a si mesmo!');
            }

            if (FollowersModel::where('follower_id', $userId)->where('followed_id', $id)->exists()) 
            {
                return redirect()->back()->with('success', 'Você já está seguindo este usuário.');
            }

            FollowersModel::create([
                'follower_id' => $userId,
                'followed_id' => $id,
            ]);

            DB::commit();
            return redirect()->back()->with('success', 'Agora você está seguindo este usuário!');
        } 
        catch (\Exception $e) 
        {
            DB::rollBack();
            return redirect()->back()->with('error', 'Erro ao seguir o usuário.');
        }
    }

    public function unfollow(int $id): RedirectResponse
    {
        try 
        {
            DB::transaction();
            $userId = session('id');

            FollowersModel::where('follower_id', $userId)
                ->where('followed_id', $id)
                ->delete();

            DB::commit();
            return redirect()->back()->with('success', 'Você deixou de seguir este usuário.');
        } 
        catch (\Exception $e) 
        {
            DB::rollBack();
            return redirect()->back()->with('error', 'Erro ao deixar de seguir o usuário.');
        }
    }

    public function followers(int $id): View
    {
        $user = UserModel::findOrFail($id);
        $followers = $user->followers()->with('follower')->paginate(50);

        return view('followers.index', compact('user', 'followers'));
    }

    public function following(int $id)
    {
        $user = UserModel::findOrFail($id);
        $following = $user->following()->with('followed')->paginate(50);

        return view('following.index', compact('user', 'following'));
    }
}

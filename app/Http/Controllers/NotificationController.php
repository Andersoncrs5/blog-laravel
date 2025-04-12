<?php

namespace App\Http\Controllers;

use App\Http\Requests\NotificationCreateRequest;
use App\Models\NotificationModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NotificationController extends Controller
{

    function get(string $id)
    {
        try
        {
            $noti = $this->get($id)->toArray();

            echo '<pre>';
            print_r($noti);

        }
        catch (\Exception $e) 
        {
            return redirect()->back()->with('error', 'Erro the get notification.');
        }
    }

    public function getAll()
    {
        try
        {
            $nots = NotificationModel::where('user_id', session('id'))->get()->toArray();

            return view('notification.getAll', compact('nots'));
        }
        catch (\Exception $e) 
        {
            return redirect()->back()->with('error', 'Erro the get notification.');
        }
    }

    function countTotalNotificationNotRead()
    {
        try
        {
            $total = NotificationModel::where('user_id', session('id'))
                ->where('is_read', false)
                ->count();

            return $total;
        }
        catch (\Exception $e) 
        {
            return redirect()->back()->with('error', 'Erro the get notification.');
        }
    }

    public function markWithVisa(string $id)
    {
        try
        {
            if(!$id) 
            {
                return redirect()->back()->with('error', 'Id is required!!!');
            }

            $noti = NotificationModel::find($id);

            if(!$noti) 
            {
                return redirect()->back()->with('error', 'Notification not found!!!');
            }

            $noti->is_read = true;
            $noti->save();

            return redirect()->back()->with('success', 'Notification marked as read.');
        }
        catch (\Exception $e) 
        {
            die($e);
            return redirect()->back()->with('error', 'Error while updating the notification.');
        }
    }
    
    public function senderAnNotification()
    {
        try
        {
            $users = UserModel::select('id', 'email')
                ->orderBy('email', 'asc') 
                ->get()
                ->toArray();

            return view('notification.sendNotifcation', compact('users'));
        }
        catch (\Exception $e) 
        {
            return redirect()->back()->with('error', 'Erro the get notification.');
        }
    }

    public function RequestsenderAnNotification(NotificationCreateRequest $r)
    {
        try
        {
            $data = $r->all();

            $data['sender_id'] = session('id');

            $data['is_read'] = false;

            NotificationModel::create($data);

            return redirect()->route('index')->with('success', 'notification sended!!!.');
        }
        catch (\Exception $e) 
        {
            echo $e;
            die();
            return redirect()->back()->with('error', 'Erro the get notification.');
        }
    }

}

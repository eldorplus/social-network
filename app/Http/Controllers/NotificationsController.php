<?php

namespace App\Http\Controllers;

use App\Notification;
use Illuminate\Support\Facades\Auth;
use Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class NotificationsController extends Controller
{
    public function received($id){
        $handle = Notification::find($id);
        $handle->is_read = 1;
        $handle->save();
        switch($handle->type){
            case 'message':
                return redirect('/messages/'.$handle->getObject()->id);
                break;
            case 'friend_invite':
                return redirect(url('/user/'.$handle->getObject()->id));
                break;
            case 'post':
                return redirect('/post/'.$handle->getObject()->id);
                break;
            case 'comment':
                return redirect('/post/'.$handle->getObject()->id);
            default:
                print_r($handle->type);
                break;
        }
    }
    public function viewAll(){
        if(Request::ajax()){
            $notifications = Auth::user()->notifications()->not_type('message')->get();
            foreach($notifications as $notification){
                $notification->is_read = 1;
                $notification->save();
            }
        }
    }
}

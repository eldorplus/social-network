<?php

namespace App\Http\Controllers;

use App\Notification;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class NotificationsController extends Controller
{
    //
    public function received($id){
        $handle = Notification::find($id);
        $handle->is_read = 1;
        $handle->save();
        switch($handle->type){
            case 'message':
                return redirect('/messages/'.$handle->getObject()->id);
                break;
            case 'friend_invite':
                return redirect('/users/'.$handle->getObject()->id);
                break;
            default:
                print_r($handle->type);
                break;
        }
    }
}
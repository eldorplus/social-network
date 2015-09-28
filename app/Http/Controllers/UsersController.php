<?php

namespace App\Http\Controllers;

use App\Post;
use App\User;
use App\Friend;
use Illuminate\Support\Facades\Auth;
use Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $posts = Post::where('author_id',Auth::id())->get();
        $user = User::find(Auth::id());
        $unreadNotifications = $user->notifications()->unread()->get()->count();
        $notifications = $user->notifications()->get();

        return view('users.my_profile')->with([
            'name'                  => Auth::user()->name,
            'surname'               => Auth::user()->surname,
            'email'                 => Auth::user()->email,
            'posts'                 => $posts,
            'new_notifications_count'      => $user->notifications()->unread()->get()->count(),
            'notifications'      => $user->notifications()->not_type('message')->get(),
            'new_messagesNotifications_count' => $user->notifications()->unread()->type('message')->get()->count(),
            'messagesNotifications' => $user->notifications()->type('message')->get()
        ]);
    }

    public function showUser($id){
        $user = User::find($id);
        if($user){

            $posts = Post::where('author_id',$id)->get();

            $unreadNotifications = $user->notifications()->unread()->get()->count();
            $notifications = $user->notifications()->get();

            if($id==Auth::id()){
                return view('users.my_profile')->with([
                    'name'                  => $user->name,
                    'surname'               => $user->surname,
                    'email'                 => $user->email,
                    'posts'                 => $posts,
                    'new_notifications_count'      => $user->notifications()->unread()->get()->count(),
                    'notifications'      => $user->notifications()->not_type('message')->get(),
                    'new_messagesNotifications_count' => $user->notifications()->unread()->type('message')->get()->count(),
                    'messagesNotifications' => $user->notifications()->type('message')->get()
                ]);
            }
            return view('users.profile')->with([
                'id'                    => $id,
                'name'                  => $user->name,
                'surname'               => $user->surname,
                'email'                 => $user->email,
                'posts'                 => $posts,
                'new_notifications_count'      => $user->notifications()->unread()->get()->count(),
                'notifications'      => $user->notifications()->not_type('message')->get(),
                'new_messagesNotifications_count' => $user->notifications()->unread()->type('message')->get()->count(),
                'messagesNotifications' => $user->notifications()->type('message')->get()
            ]);
        }else{
            abort(404);
        }
    }

    public function getAddFriend($id)
    {
        $user = new Friend;
        $friend = new Friend;

        $user->user1_id = Auth::id();
        $user->user2_id = $id;
        $user->invited_by = Auth::id();
        $user->touch();
        $user->save();

        $friend->user2_id = Auth::id();
        $friend->user1_id = $id;
        $friend->invited_by = Auth::id();
        $friend->touch();
        $friend->save();

        $user = User::find($id);
        $user->newNotification()
            ->withType('friend_invite')
            ->withSubject($user->name.' '.$user->surname.' invited you!')
            ->withBody('Go to her/his profile')
            ->regarding($user)
            ->deliver();
        return Redirect::back();
    }
    public function getRemoveFriend($id)
    {
        $user = Friend::where([
            'user1_id'=>Auth::id(),
            'user2_id'=>$id
        ])->first();
        Friend::destroy($user->id);
        $friend = Friend::where([
            'user2_id'=>Auth::id(),
            'user1_id'=>$id
        ])->first();
        Friend::destroy($friend->id);
        return Redirect::back();
    }
    public function getConfirmFriend($id)
    {
        $user = Friend::where([
            'user1_id'=>Auth::id(),
            'user2_id'=>$id
        ])->first();
        $handle = Friend::find($user->id);
        $handle->is_accepted = 1;
        $handle->save();
        $friend = Friend::where([
            'user2_id'=>Auth::id(),
            'user1_id'=>$id
        ])->first();
        $handle =Friend::find($friend->id);
        $handle->is_accepted = 1;
        $handle->save();
        return Redirect::back();
    }

}

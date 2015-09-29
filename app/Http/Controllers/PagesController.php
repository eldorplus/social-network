<?php

namespace App\Http\Controllers;

use App\Post;
use App\Relation;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class PagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = PostsController::getFriendsAndUsersPosts();
        if(Auth::check()){


            $user = User::find(Auth::id());
            return view('pages.index')->with([
                'posts'               => $posts,
                'new_notifications_count'      => $user->notifications()->unread()->not_type('message')->get()->count(),
                'notifications'      => $user->notifications()->not_type('message')->get(),
                'new_messagesNotifications_count' => $user->notifications()->unread()->type('message')->get()->count(),
                'messagesNotifications' => $user->notifications()->type('message')->get()
            ]);
        }
        return view('pages.index');
    }

    public function contact(){
        if(Auth::check()){
            $user = User::find(Auth::id());
            $unreadNotifications = $user->notifications()->unread()->get()->count();
            $notifications = $user->notifications()->get();
            return view('pages.contact')->with([
                'new_notifications_count'      => $user->notifications()->unread()->not_type('message')->get()->count(),
                'notifications'      => $user->notifications()->not_type('message')->get(),
                'new_messagesNotifications_count' => $user->notifications()->unread()->type('message')->get()->count(),
                'messagesNotifications' => $user->notifications()->type('message')->get()
            ]);
        }
        return view('pages.contact');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
}

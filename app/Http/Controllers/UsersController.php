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
        return view('users.my_profile')->with([
            'name' => Auth::user()->name,
            'surname' => Auth::user()->surname,
            'email' => Auth::user()->email,
            'posts' => $posts
        ]);
    }

    public function showUser($id){
        $user = User::find($id);
        if($user){

            $posts = Post::where('author_id',$id)->get();

            if($id==Auth::id()){
                return view('users.my_profile')->with([
                    'name' => $user->name,
                    'surname' => $user->surname,
                    'email' => $user->email,
                    'posts' => $posts
                ]);
            }
            return view('users.profile')->with([
                'id'  => $id,
                'name' => $user->name,
                'surname' => $user->surname,
                'email' => $user->email,
                'posts' => $posts
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

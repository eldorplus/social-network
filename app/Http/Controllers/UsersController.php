<?php

namespace App\Http\Controllers;

use App\Post;
use App\User;
use Illuminate\Support\Facades\Auth;
use Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

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
            return "nie ma takiego usera";
        }
    }

    public function getAddFriend($id)
    {
        Auth::user()->addFriend($id);
        return Redirect::back();
    }
    public function getRemoveFriend($id)
    {
        Auth::user()->removeFriend($id);
        return Redirect::back();
    }
}

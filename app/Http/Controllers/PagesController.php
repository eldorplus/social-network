<?php

namespace App\Http\Controllers;

use App\Post;
use App\Relation;
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
        $posts = Post::whereIn('author_id',Relation::where('user_1',Auth::id())->get(['user_2']))
                        ->orWhere('author_id',Auth::id())->orderBy('created_at','DESC')->get();
        return view('pages.index')->with('posts',$posts);
    }

    public function contact(){
        return view('pages.contact');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
}

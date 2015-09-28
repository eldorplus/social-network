<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Request;
use App\Http\Requests;
use App\Post;
use App\Friend;
use App\Http\Controllers\Controller;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        $posts = Post::latest()->get();
        return view('posts.all')->with([
            'posts'=>$posts,
            'new_notifications_count'      => Auth::user()->notifications()->unread()->get()->count(),
            'notifications'      => Auth::user()->notifications()->not_type('message')->get(),
            'new_messagesNotifications_count' => Auth::user()->notifications()->unread()->type('message')->get()->count(),
            'messagesNotifications' => Auth::user()->notifications()->type('message')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $input = Request::all();
        $input['published_at']=Carbon::now();
        $input['author_id']=Auth::id();
        Post::create($input);
        return redirect('/');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $post = Post::find($id);
        if($post){
            return view('posts.single')->with([
                'post' => $post
            ]);
        }else{
            abort(404);
        }


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $post = Post::find($id);
        if($post){
            return view('posts.edit')->with([
                'post' => $post
            ]);
        }else{
            abort(404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        //
        $input = Request::all();
        $post = Post::find($id);
        $post->body = $input['body'];
        $post->save();
        return redirect('/');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $post = Post::find($id);
        $post->delete();
        return redirect('/');
    }

    public static function getFriendsAndUsersPosts(){
        $friends = Friend::where('user1_id',Auth::id())->where('is_accepted',1)->get(['user2_id']);
        $friends->push(['user2_id'=>Auth::id()]);
        $posts = Post::whereIn('author_id',$friends)->get();
        return $posts;
    }
}

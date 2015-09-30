<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Request;
use App\Http\Requests;
use App\Post;
use App\User;
use App\Friend;
use App\Vote;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

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
                'post' => $post,
                'new_notifications_count'      => Auth::user()->notifications()->unread()->not_type('message')->get()->count(),
                'notifications'      => Auth::user()->notifications()->not_type('message')->get(),
                'new_messagesNotifications_count' => Auth::user()->notifications()->unread()->type('message')->get()->count(),
                'messagesNotifications' => Auth::user()->notifications()->type('message')->get()
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

    public function upvote($id){
        if ( Request::ajax() ){
            $post = Post::find($id);
            $_downvote_handle = Vote::where('object_id','=',Auth::id())
                                        ->where('type','=','downvote')
                                        ->where('post_id','=',$id)
                                        ->first();
            if($_downvote_handle){
                $_downvote_handle->delete();

                //TODO: add in notifications table column 'sender_id' to track down user responsible for notification
                //TODO: delete previous notification from sender regarding current post upvote/downvote

//                $_notification_handle = Notification::where('type','=','post')
//                                                        ->where('object_id','=',$id)
//                                                        ->where('user_id','=',$post->author_id)
//                                                        ->first();
            }
            $post->newVote()
                ->withType('upvote')
                ->regarding(Auth::user())
                ->deliver();
            $user = Auth::user();
            $post_author = User::find($post->author_id);
            $post_author->newNotification()
                ->withType('post')
                ->withSubject($user->name.' '.$user->surname.' upvoted your post.')
                ->withBody('"'.$post->body.'"')
                ->regarding($post)
                ->deliver();

            return array(
                'data1' => $post->votes()->type('upvote')->get()->count(),
                'data2' => $post->votes()->type('downvote')->get()->count()
            );
        }
    }
    public function downvote($id){
        if ( Request::ajax() ){
            $post = Post::find($id);
            $_upvote_handle = Vote::where('object_id','=',Auth::id())->where('type','=','upvote')->where('post_id','=',$id)->first();
            if($_upvote_handle){
                $_upvote_handle->delete();
            }
            $post->newVote()
                ->withType('downvote')
                ->regarding(Auth::user())
                ->deliver();
            $user = Auth::user();
            $post_author = User::find($post->author_id);
            $post_author->newNotification()
                ->withType('post')
                ->withSubject($user->name.' '.$user->surname.' downvoted your post.')
                ->withBody('"'.$post->body.'"')
                ->regarding($post)
                ->deliver();
            return array(
                'data1' => $post->votes()->type('downvote')->get()->count(),
                'data2' => $post->votes()->type('upvote')->get()->count()
            );
        }
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
        if ( Request::ajax() ){
            $post = Post::find($id);
            $post->delete();
        }
    }

    public static function getFriendsAndUsersPosts(){
        $friends = Friend::where('user1_id',Auth::id())->where('is_accepted',1)->get(['user2_id']);
        $friends->push(['user2_id'=>Auth::id()]);
        $posts = Post::whereIn('author_id',$friends)->get();
        return $posts;
    }
}

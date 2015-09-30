<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Request;
use App\Http\Requests;
use App\Post;
use App\Comment;
use App\User;
use App\Http\Controllers\Controller;

class CommentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$id)
    {
        //
        if(Request::ajax()){
            $input = Request::all();
            $post = Post::find($id);
            $user = Auth::user();
            $post->newComment()->withAuthor($user->id)->withBody($input['body'])->deliver();

            $post_author = User::find($post->author_id);

            if($post_author->id != $user->id){
                $post_author->newNotification()
                    ->withType('comment')
                    ->withSubject($user->name.' '.$user->surname.' commented on your post!')
                    ->withBody('"'.$input['body'].'"')
                    ->regarding($post)
                    ->deliver();
            }

            return [
                'comments-count' => $post->comments()->get()->count(),
                'user-name'      => Auth::user()->name,
                'user-surname'   => Auth::user()->surname,
                'user-id'        => Auth::id()
            ];
        }
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
    }
}

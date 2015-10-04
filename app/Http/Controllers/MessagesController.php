<?php

namespace App\Http\Controllers;

use Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Message;
use App\User;
use App\Conversation;
use App\ConversationUser;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class MessagesController extends Controller
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





    public function createPrivate($id){
        $handle = Auth::user()->hasConversation($id);
        if($handle){
            return redirect('/messages/'.$handle->conversation_id);
        }else{
            $privateConversationId = ConversationsController::createPrivateConversation(Auth::id(),$id);
            Conversation::find($privateConversationId)->title = ConversationsController::getUsersString($privateConversationId);
            return redirect('/messages/'.$privateConversationId);
        }
    }

    public function store(Request $request, $id)
    {
        //
        //
        $conversation = Conversation::find($id);
        $conversation->touch();
        $input = Request::all();
        $input['published_at']=Carbon::now();
        $input['author_id']=Auth::id();
        $input['conversation_id']=$id;
        Message::create($input);

        $to_users = ConversationUser::where('conversation_id',$id)->where('user_id','!=',Auth::id())->get(['user_id']);

        foreach($to_users as $_user){
            $user = User::find($_user->user_id);
            $user->newNotification()
                ->withType('message')
                ->withSender(Auth::id())
                ->withSubject($conversation->title)
                ->withBody($input['body'])
                ->regarding($conversation)
                ->deliver();
        }

        return redirect('/messages/'.$id);
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

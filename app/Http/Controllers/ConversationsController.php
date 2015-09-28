<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Conversation;
use App\Message;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\ConversationUser;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;

class ConversationsController extends Controller
{

    public function getUsersString($id){
        $result = "";
        $_users = ConversationUser::where([
            'conversation_id'=>$id
        ])->get(['user_id']);
        $users = User::whereIn('id',$_users)->get();
        foreach($users as $user){
            if($user->id!=Auth::id()){
                $result = $result.$user->name." ".$user->surname.", ";
            }
        }

        return  rtrim($result, ", ");;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $_conversations = Conversation::orderBy('updated_at','desc')->get();

        $conversations = collect();
        foreach($_conversations as $_conversation){

            $conversation = Array();

            if($_conversation->title===""){
                $_conversation->title = ConversationsController::getUsersString($_conversation->id);
            }

            $lastMessage = Message::where(['conversation_id'  =>$_conversation->id])->orderBy('updated_at', 'desc')->first();
            if($lastMessage){
                $lastSender = User::find($lastMessage->author_id);
                $conversation['user_name']=$lastSender->name." ".$lastSender->surname;
                $conversation['message_body']=$lastMessage->body;
                $conversation['user_id']=$lastSender->id;
            }


            $conversation['id']=$_conversation->id;
            $conversation['title']=$_conversation->title;
            $conversation['timestamp']=$_conversation->updated_at;
            $conversations->push($conversation);

        }

            $user = User::find(Auth::id());
            $unreadNotifications = $user->notifications()->unread()->get()->count();
            $notifications = $user->notifications()->get();

            return view('conversations.conversations')->with([
                "conversations" => $conversations,
                'new_notifications_count'      => $user->notifications()->unread()->get()->count(),
                'notifications'      => $user->notifications()->not_type('message')->get(),
                'new_messagesNotifications_count' => $user->notifications()->unread()->type('message')->get()->count(),
                'messagesNotifications' => $user->notifications()->type('message')->get()
            ]);

    }

    public function getConversation($id){
        $_messages = Message::where([
            'conversation_id' => $id
        ])->orderBy('updated_at','desc')->get();
        $_conversation = Conversation::find($id);

        $messages = collect();
        foreach($_messages as $_message){
            $sender = User::find($_message->author_id);

            $message = Array();
            $message['author_id'] = $_message->author_id;
            $message['body'] = $_message->body;
            $message['author_name'] = $sender->name;
            $message['author_surname'] = $sender->surname;
            $message['timestamp'] = $sender->updated_at;
            $messages->push($message);
        }
        $conversation_name = "";
        if($_conversation->name==""){
            $conversation_name =ConversationsController::getUsersString($id);
        }else{
            $conversation_name = $_conversation->name;
        }


        $user = User::find(Auth::id());
        $unreadNotifications = $user->notifications()->unread()->get()->count();
        $notifications = $user->notifications()->get();

        return view('conversations.conversation')->with([
            'messages'              => $messages,
            'conversation_name'     => $conversation_name,
            'id'                    => $id,
            'new_notifications_count'      => $user->notifications()->unread()->get()->count(),
            'notifications'      => $user->notifications()->not_type('message')->get(),
            'new_messagesNotifications_count' => $user->notifications()->unread()->type('message')->get()->count(),
            'messagesNotifications' => $user->notifications()->type('message')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public static function createPrivateConversation($user1,$user2)
    {
        //
        $newPrivateConversation = new Conversation;
        $newPrivateConversation->touch();
        $newPrivateConversation->save();

        $user1relation = new ConversationUser;
        $user1relation->conversation_id = $newPrivateConversation->id;
        $user1relation->user_id = $user1;
        $user1relation->touch();
        $user1relation->save();

        $user2relation = new ConversationUser;
        $user2relation->conversation_id = $newPrivateConversation->id;
        $user2relation->user_id = $user2;
        $user2relation->touch();
        $user2relation->save();

        return $newPrivateConversation->id;
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

<?php

namespace App;


use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name','surname', 'email', 'password'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    function friends()
    {
        return $this->belongsToMany('App\User', 'friends', 'user1_id', 'user2_id');
    }
    function friendsOfGiven($id)
    {
        $user = User::find($id);

        return $user->belongsToMany('App\User', 'friends', 'user1_id', 'user2_id');
    }
    // friendship that I started
    function friendsOfMine()
    {
        return $this->belongsToMany('App\User', 'friends', 'user1_id', 'user2_id')
            ->wherePivot('is_accepted', '=', true) // to filter only is_accepted
            ->withPivot('is_accepted'); // or to fetch is_accepted value
    }

    // friendship that I was invited to
    function friendOf()
    {
        return $this->belongsToMany('App\User', 'friends', 'user2_id', 'user1_id')
        ->wherePivot('is_accepted', '=', true)
        ->withPivot('is_accepted');
    }

    // accessor allowing you call $user->friends
    public function getFriendsAttribute()
    {
        if ( ! array_key_exists('friends', $this->relations)) $this->loadFriends();

        return $this->getRelation('friends');
    }

    protected function loadFriends()
    {
        if ( ! array_key_exists('friends', $this->relations))
        {
            $friends = $this->mergeFriends();

            $this->setRelation('friends', $friends);
        }
    }

    protected function mergeFriends()
    {
        return $this->friendsOfMine->merge($this->friendOf);
    }
    public function isFriend($id)
    {
        // Get both user
        $user = Auth::user();
        $receiver = User::where('id', $id)->first();

        $result = Friend::where('is_accepted',1)->where(function($query) use ($receiver,$user)
        {
            $query->where([
                'user1_id'   => $user->id,
                'user2_id' => $receiver->id
            ])->orWhere([
                'user1_id'   => $receiver->id,
                'user2_id' => $user->id
            ]);

        })->get();

        return ! $result->isEmpty();
    }
    public function hasConversation($id)
    {
        $user = Auth::user();
        $receiver = User::where('id', $id)->first();

        $userConversations = ConversationUser::where('user_id','=',$user->id)
                                                ->get(['conversation_id']);

        $receiverAndUserCommon = ConversationUser::where('user_id',$receiver->id)
                                                    ->whereIn('conversation_id',$userConversations)
                                                    ->get(['conversation_id']);

        if(!$receiverAndUserCommon->isEmpty()){

            $otherConversations = ConversationUser::whereNotIn('user_id',array($user->id,$receiver->id))
                                                        ->get(['conversation_id']);

            $privateConversation = ConversationUser::whereIn('conversation_id',$receiverAndUserCommon)
                                                        ->whereNotIn('conversation_id',$otherConversations)
                                                        ->first();
            if($privateConversation){
                return $privateConversation;
            }
            return false;
        }
        return false;
    }

    public function invitationSend($id){
        $user = Auth::user();
        $receiver = User::where('id', $id)->first();

        $result = Friend::where('invited_by',$user->id)->where(function($query) use ($receiver,$user)
        {
            $query->where([
                'user1_id'   => $user->id,
                'user2_id' => $receiver->id
            ])->orWhere([
                'user1_id'   => $receiver->id,
                'user2_id' => $user->id
            ]);

        })->get();

        return ! $result->isEmpty();
    }
    public function invitationReceived($id){
        $user = Auth::user();
        $receiver = User::where('id', $id)->first();

        $result = Friend::where('invited_by',$receiver->id)->where(function($query) use ($receiver,$user)
        {
            $query->where([
                'user1_id'   => $user->id,
                'user2_id' => $receiver->id
            ])->orWhere([
                'user1_id'   => $receiver->id,
                'user2_id' => $user->id
            ]);

        })->get();

        return ! $result->isEmpty();
    }
    public function removeFriend($id)
    {
        $this->friends()->detach($id);
    }

}

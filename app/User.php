<?php

namespace App;


use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
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
        return $this->belongsToMany('App\User', 'friends', 'user_id', 'friend_id')
            ->wherePivot('accepted', '=', 1);
    }
    // friendship that I started
    function friendsOfMine()
    {
        return $this->belongsToMany('App\User', 'friends', 'user_id', 'friend_id')
            ->wherePivot('accepted', '=', 1) // to filter only accepted
            ->withPivot('accepted'); // or to fetch accepted value
    }

    // friendship that I was invited to
    function friendOf()
    {
        return $this->belongsToMany('App\User', 'friends', 'friend_id', 'user_id')
        ->wherePivot('accepted', '=', 1)
        ->withPivot('accepted');
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

        $result = Friends::where('status',1)->where(function($query) use ($receiver,$user)
        {
            $query->where([
                'user_id'   => $user->id,
                'friend_id' => $receiver->id
            ])->orWhere([
                'user_id'   => $receiver->id,
                'friend_id' => $user->id
            ]);

        })->get();

        return ! $result->isEmpty();
    }
    public function addFriend($id)
    {
        $this->friends()->attach($id);
    }

    public function removeFriend($id)
    {
        $this->friends()->detach($id);
    }
}

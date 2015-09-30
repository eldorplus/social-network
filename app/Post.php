<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //
    protected $table = 'posts';
    protected $fillable = ['author_id','body'];

    public function votes()
    {
        return $this->hasMany('App\Vote');
    }

    public function newVote()
    {
        $vote = new Vote;
        $vote->post()->associate($this);

        return $vote;
    }
    public function comments(){
        return $this->hasMany('App\Comment');
    }
    public function newComment(){
        $comment = new Comment;
        $comment->post()->associate($this);

        return $comment;
    }
}

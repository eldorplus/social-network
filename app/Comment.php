<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    //
    protected $table = 'comments';
    protected $fillable = ['author_id','body','post_id'];

    public function getDates()
    {
        return ['created_at', 'updated_at'];
    }
    public function withAuthor($subject)
    {
        $this->author_id = $subject;

        return $this;
    }

    public function withBody($body)
    {
        $this->body = $body;

        return $this;
    }
    public function withPost($post){
        $this->post_id = $post;

        return $this;
    }

    public function post()
    {
        return $this->belongsTo('App\Post');
    }

    public function deliver()
    {
        $this->save();

        return $this;
    }
    public function scopeType($query, $type)
    {
        return $query->where('type', '=', $type);
    }


}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    //
    protected $table = 'messages';
    protected $fillable = ['body','author_id','conversation_id'];

    // TODO: poprawić ten model i kontroler do niego, żeby łatwiej można było tworzyć i filtrować obiekty
}

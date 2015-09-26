<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Picture extends Model
{
    //
    protected $table = 'pictures';
    protected $fillable = ['uuid','path','owner_id'];

}

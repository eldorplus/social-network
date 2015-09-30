<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Vote extends Model
{
    //
    protected $table = 'votes';
    protected $fillable = ['post_id','type','object_id','object_type'];
    private $relatedObject = null;

    public function getDates()
    {
        return ['created_at', 'updated_at'];
    }

    public function post()
    {
        return $this->belongsTo('App\Post');
    }

    public function withType($type)
    {
        $this->type = $type;

        return $this;
    }

    public function regarding($object)
    {
        if(is_object($object))
        {
            $this->object_id   = $object->id;
            $this->object_type = get_class($object);
        }

        return $this;
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
    public function scopeVoted($query){
        return $query->where('object_id','=',Auth::id());
    }
    public function hasValidObject()
    {
        try
        {
            $object = call_user_func_array($this->object_type . '::findOrFail', [$this->object_id]);
        }
        catch(\Exception $e)
        {
            return false;
        }

        $this->relatedObject = $object;

        return true;
    }

    public function getObject()
    {
        if(!$this->relatedObject)
        {
            $hasObject = $this->hasValidObject();

            if(!$hasObject)
            {
                throw new \Exception(sprintf("No valid object (%s with ID %s) associated with this notification.", $this->object_type, $this->object_id));
            }
        }

        return $this->relatedObject;
    }
}

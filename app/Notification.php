<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    //
    protected $table = 'notifications';
    protected $fillable = ['user_id','sender_id','type','subject','body','object_id','object_type','is_read','send_at'];
    private $relatedObject = null;

    public function getDates()
    {
        return ['created_at', 'updated_at', 'sent_at'];
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function withSubject($subject)
    {
        $this->subject = $subject;

        return $this;
    }
    public function withSender($id){
        $this->sender_id = $id;

        return $this;
    }
    public function withBody($body)
    {
        $this->body = $body;

        return $this;
    }
    public function isRead(){
        return $this->is_read;
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
        $this->sent_at = new Carbon;
        $this->save();

        return $this;
    }
    public function scopeUnread($query)
    {
        return $query->where('is_read', '=', 0);
    }
    public function scopeType($query, $type)
    {
        return $query->where('type', '=', $type);
    }
    public function scopeNot_type($query,$type){
        return $query->where('type', '!=', $type);
    }
    public function scopeInvitation($query)
    {
        return $query->where('type', '=', 'friend_invite');
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

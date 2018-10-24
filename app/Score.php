<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    protected $table = 'score';

    protected $fillable = [
    	'city_id',
    	'user_id',
    	'event_id',
    	'value'
    ];


    public function city()
    {
    	return $this->belongsTo('App\City','city_id');
    }

    public function user()
    {
    	return $this->belongsTo('App\User','user_id');
    }

    public function event()
    {
    	return $this->belongsTo('App\Event','event_id');
    }


    public static function get($eventId, $missId, $userId)
    {
       $vote = self::where('event_id',$eventId)->where('city_id',$missId)->where('user_id',$userId)->first();
       if ($vote) {
           return $vote->value;
       }
       return false;
    }

    public static function getId($eventId, $missId, $userId)
    {
       $vote = self::where('event_id',$eventId)->where('city_id',$missId)->where('user_id',$userId)->first();
       if ($vote) {
           return $vote->id;
       }
       return false;
    }
}

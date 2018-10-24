<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    protected $table = 'score';

    protected $fillable = [
    	'miss_id',
    	'user_id',
    	'event_id',
    	'value'
    ];


    public function miss()
    {
    	return $this->belongsTo('App\Miss','miss_id');
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
       $vote = self::where('event_id',$eventId)->where('miss_id',$missId)->where('user_id',$userId)->first();
       if ($vote) {
           return $vote->value;
       }
       return false;
    }

    public static function getId($eventId, $missId, $userId)
    {
       $vote = self::where('event_id',$eventId)->where('miss_id',$missId)->where('user_id',$userId)->first();
       if ($vote) {
           return $vote->id;
       }
       return false;
    }
}

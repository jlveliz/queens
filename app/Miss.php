<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Miss extends Model
{
    protected $table = 'miss';

    protected $fillable = [
    	'name',
    	'last_name',
    	'age',
    	'city_id',
    	'height',
    	'measurements',
    	'activities',
    	'hobbies',
    	'photos',
    	'semifinalist',
    	'state'
    ];


    public function city()
    {
    	return $this->belongsTo('App\City','city_id');
    }
  
}

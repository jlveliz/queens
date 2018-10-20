<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Miss extends Model
{
    protected $table = 'miss';

    public $timestamps = false;

    protected $fillable = ['*'];


    public function city()
    {
    	return $this->belongsTo('App\City','city_id');
    }
  
}

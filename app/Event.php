<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $table = 'event';

    protected $fillable = [
    	'is_current',
        'name',
        'state'
    ];

    public function getCurrent()
    {
        return $this->where('is_current',1)->first();
    }
  
}

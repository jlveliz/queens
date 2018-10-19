<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Miss extends Model
{
    protected $table = 'miss';

    public $timestamps = false;

    protected $fillable = [
    	'idcanton',
    	'nombres',
    	'apellidos',
    	'edad',
    	'estatura',
    	'medidas',
    	'actividades',
    	'hobbies',
    	'fotos',
    	'semifinalista'
    ];


    
}

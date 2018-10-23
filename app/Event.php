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

    public function generateSlug()
    {
        return str_slug($this->name);
    }

    public function getImg($disabled = false)
    {
        $name = strtolower(trim(str_replace(' ', '', $this->name)));
        $img = "images/ronda_preguntas.png";
        
        if (strrpos($name,'baño')) {
            if ($disabled) {
                $img = 'images/vestido_traje_banio_disabled.png';
            } else {
                $img = 'images/vestido_traje_banio.png';
            }
        }

        if (strrpos($name,'noche')) {
            if ($disabled) {
                $img = 'images/vestido_noche_disabled.png';
            } else {
                $img = 'images/vestido_noche.png';
            }
        }

        if (strrpos($name,'típico')) {
            if ($disabled) {
                $img = 'images/traje_tipico_disabled.png';
            } else {
                $img = 'images/traje_tipico.png';
            }
        }

        if (strrpos($name,'preguntas')) {
            if ($disabled) {
                $img = 'images/ronda_preguntas_disabled.png';
            }
        }

        return $img;
    }
  
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use DB;

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


    public function getScore()
    {
        $judges = (new User())->getJudges();
        $numJudges = count($judges->toArray());
        $idJudges = [];
        
        foreach($judges as $key =>  $judge){
            $idJudges[$key] = $judge->id;
        }
       


        $sql = "SELECT city.`name` ";
        //sum cada juez
        for ($i=0; $i < $numJudges ; $i++) { 
            $sql.= ", IFNULL(juez".($i+1).".`sum_score`, 0) AS juez".($i+1)." ";
        }
        //sumatoria
        $sql.= ", (";
        for ($i=0; $i < $numJudges ; $i++) { 
            $sql.= " juez".($i+1).".sum_score ";
            if (($i+1) < $numJudges) {
               $sql.="+";
            }
        }
        $sql.= ") sumatoria";


        //promedio
        $sql.= ", ROUND((";
        for ($i=0; $i < $numJudges ; $i++) { 
            $sql.= " juez".($i+1).".sum_score ";
            if (($i+1) < $numJudges) {
               $sql.="+";
            }
        }
        $sql.= ") / ".$numJudges.", 2)  promedio";


        $sql.= " FROM city,";
        

        //add froms
        for ($i=0; $i < $numJudges ; $i++) { 
            $sql.= "( SELECT score.city_id, SUM(score.`value`) sum_score FROM score WHERE score.user_id = ".$idJudges[$i]."  and score.event_id = ".$this->id." GROUP BY score.city_id ) juez".($i+1)." ";
            if (($i+1) < $numJudges) {
               $sql.=",";
            }
        }

        //add wheres
        $sql.= " WHERE ";
        for ($i=0; $i < $numJudges ; $i++) { 
            $sql.= " city.id = juez".($i+1).".city_id ";
            if (($i+1) < $numJudges) {
               $sql.="AND";
            }
        }

        $sql.= "ORDER BY city.`name` ASC";


        return $dataEvent =  DB::select(DB::raw($sql));
        
    }
  
}

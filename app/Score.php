<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Repository\EventRepository;
use DB;

class Score extends Model
{
    protected $table = 'score';

    protected $fillable = [
    	'city_id',
    	'user_id',
    	'event_id',
    	'value',
      'round_of_questions'
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


    public static function get($eventId, $cityId, $userId)
    {
       $vote = self::where('event_id',$eventId)->where('city_id',$cityId)->where('user_id',$userId)->first();
       if ($vote) {
           return $vote->value;
       }
       return false;
    }

    public static function getId($eventId, $cityId, $userId)
    {
      
       $vote = self::where('event_id',$eventId)->where('city_id',$cityId)->where('user_id',$userId)->first();
       if ($vote) {
           return $vote->id;
       }
       return false;
    }


    public static function getScore($eventsId = null, $filter = null)
    {
        //buscando en eventos
        if(!$eventsId) {
          $eventsId = "";
          $eventRepo = (new EventRepository())->getActives();

          for ($i=0; $i < count($eventRepo->toArray());$i++) {
            $eventsId.= $eventRepo[$i]->id;
            if( ($i+1) < count($eventRepo->toArray())) {
              $eventsId.=", ";
            }
          }
        }

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
            $sql.= "( SELECT score.city_id, SUM(score.`value`) sum_score FROM score WHERE score.user_id = ".$idJudges[$i]."  and score.event_id in (".$eventsId.") GROUP BY score.city_id ) juez".($i+1)." ";
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

        if ($filter) {
          switch ($filter) {
            case 'semifinalist':
              $sql .= " ORDER BY sumatoria DESC LIMIT 10";
              break;
            case 'finalist':
              $sql .= " ORDER BY sumatoria DESC LIMIT 5";
              break;
            default:
              break;
          }
        } else {
          $sql.= "ORDER BY city.`name` ASC";
        }



        return $dataEvent =  DB::select(DB::raw($sql));
        
    }

    public static function getFullScore()
    {
      
      //events
      $eventRepo = (new EventRepository())->getActives();
      $numAllEvents = count($eventRepo->toArray());
      
      $eventsNormalId = [];
      $rondaPreguntasId = null;
      foreach ($eventRepo as $key => $event) {
          if ($event->generateSlug() != "ronda-de-preguntas") {
            $eventsNormalId[$key] = $event->id;
          }else {
            $rondaPreguntasId = $event->id;
          }
      }

      //jueces
      $judges = (new User())->getJudges();
      $numJudges = count($judges->toArray());
      $idJudges = [];
      
      foreach($judges as $key =>  $judge){
        $idJudges[$key] = $judge->id;
      }

      $sql = "SELECT city.name as canton, ";

      for ($i=0; $i < count($eventsNormalId) ; $i++) { 
          
          for ($j=0; $j < $numJudges; $j++) { 
            $sql.= "ju".($j+1)."ev".($i +1).".scoreval score_ju_".($j+1)."_event".($i+1);
            if (($j+1) < $eventsNormalId) {
              $sql.=", ";
            }
          }
          
          // if (($i+1) < count($eventsNormalId)) {
          //   $sql.=", ";
          // }

          //sumatorios
          $sql.=" ( ";
          for ($j=0; $j < $numJudges; $j++) { 
            $sql.= "ju".($j+1)."ev".($i + 1).".scoreval";
            if (($j+1) < $numJudges) {
              $sql.=" + ";
            }
          }
          
          $sql.=" ) sum_event_".($i+1);
          if (($i+1) <= count($eventsNormalId)) {
            $sql.=", ";
          }

          //promedios
          $sql.="ROUND ( ( ";
          for ($j=0; $j < $numJudges; $j++) { 
            $sql.= "ju".($j+1)."ev".($i + 1).".scoreval";
            if (($j+1) < $numJudges) {
              $sql.=" + ";
            }
          }
          
          $sql.=" ) / ".$numJudges.",2 ) prom_event_".($i+1). " ";
          if (($i+1) < count($eventsNormalId)) {
            $sql.=", ";
          }
      }

      $sql.= ", (";
      for ($i=0; $i < count($eventsNormalId); $i++) { 
        $sql.="(";
        for ($j=0; $j < $numJudges; $j++) { 
          $sql.= "ju".($j+1)."ev".($i + 1).".scoreval";
          if (($j+1) < $numJudges) {
            $sql.=" + ";
          }
        }
        $sql.=")";
        if (($i+1) < count($eventsNormalId)) {
          $sql.=" + ";
        }
      }
      $sql.= " ) semifinal, ";

      //RONDA DE PREGUNTAS
      for ($j=0; $j < $numJudges ; $j++) { 
        $sql.= "ju".($j+1)."ev4.scoreval score_ju_".($j+1)."_event4";
        if (($j+1) <= $numJudges) {
          $sql.=", ";
        }
      }

      $sql.= " (";
      for ($j=0; $j < $numJudges ; $j++) { 
        $sql.= "ju".($j+1)."ev4.scoreval ";
        if (($j+1) < $numJudges) {
          $sql.=" + ";
        }
      }

      $sql.= ") sum_event_4, ";

      $sql.= " ROUND( ( ";
      for ($j=0; $j < $numJudges; $j++) {
        $sql.= "ju".($j+1)."ev4.scoreval ";
        if (($j+1) < $numJudges) {
          $sql.=" + ";
        }  
      }
      $sql.= "/".$numJudges." ),2  ) prom_event_4, ";
      

      //gran total
      $sql.= "( ";
      for ($i=0; $i < $numAllEvents ; $i++) { 
        $sql.=" ( ";
        for ($j=0; $j < $numJudges; $j++) { 
          $sql.=" ju".($j+1)."ev".($i+1).".scoreval";
          if (($j+1) < $numJudges) {
            $sql.=" + ";
          }
        }
        $sql.=")";
        if (($i+1) < $numAllEvents) {
          $sql.=" + ";
        }
      }

      $sql.=") gran_total, ";


       //gran total
      $sql.= "ROUND ( ( ";
      for ($i=0; $i < $numAllEvents ; $i++) { 
        $sql.=" ( ";
        for ($j=0; $j < $numJudges; $j++) { 
          $sql.=" ju".($j+1)."ev".($i+1).".scoreval";
          if (($j+1) < $numJudges) {
            $sql.=" + ";
          }
        }
        $sql.=")";
        if (($i+1) < $numAllEvents) {
          $sql.=" + ";
        }
      }

      $sql.=") / ".$numJudges."  , 2) promedio_final ";



      //from
      $sql.= " FROM city ,"; 

      for ($i=0; $i < count($eventsNormalId) ; $i++) {
        for ($j=0; $j < $numJudges; $j++) { 
          $sql.= "ju".($j+1)."ev".($i+1)." ";
          if (($j+1) <= $numJudges) {
              $sql.=" , ";
          }
        }
      }
      
      for ($j=0; $j < $numJudges ; $j++) { 
        $sql.= "ju".($j+1)."ev4";
          if (($j+1) < $numJudges) {
              $sql.=" , ";
          }
      }




      //where
      $sql.= " WHERE "; 
      for ($i=0; $i < count($eventsNormalId) ; $i++) {
        for ($j=0; $j < $numJudges; $j++) { 
          $sql.= "city.id = ju".($j+1)."ev".($i+1).".idcanton ";
          if (($j+1) <= $numJudges) {
              $sql.=" AND ";
          }
        }
      }

      for ($j=0; $j < $numJudges; $j++) { 
          $sql.= "city.id = ju".($j+1)."ev4.idcanton";
          if (($j+1) < $numJudges) {
              $sql.=" AND ";
          }
        }
      
      $sql.=" order by gran_total desc ";

      

      return $dataEvent =  DB::select(DB::raw($sql));


       

    }
}

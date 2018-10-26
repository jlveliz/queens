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
      $numEvents = count($eventRepo->toArray());
      $idEvents = [];
      foreach ($eventRepo as $key => $event) {
          $idEvents[$key] =  $event->id;
      }


      //jueces
      $judges = (new User())->getJudges();
      $numJudges = count($judges->toArray());
      $idJudges = [];
      
      foreach($judges as $key =>  $judge){
        $idJudges[$key] = $judge->id;
      }

      $sql = "SELECT city.`name` ";
        
        //events
        for ($i=0; $i < $numEvents ; $i++) { 
          //juez
          for ($j=0; $j < $numJudges ; $j++) { 
              $sql.= ", IFNULL(juez_".($j+1)."_event_".($i+1).".`sum_score`, 0) AS juez_".($j+1)."_event_".($i+1)."";
          }

          $sql.= ", (";
          for ($j=0; $j < $numJudges ; $j++) { 
              $sql.= " juez_".($j+1)."_event_".($i+1).".sum_score ";
              if (($j+1) < $numJudges) {
                 $sql.="+";
              }
          }
          $sql.= ") sumatoria_event_".($i+1);

          //promedio
          $sql.= ", ROUND((";
          for ($j=0; $j < $numJudges ; $j++) { 
              $sql.= " juez_".($j+1)."_event_".($i+1).".sum_score ";
              if (($j+1) < $numJudges) {
                 $sql.="+";
              }
          }
          $sql.= ") / ".$numJudges.", 2)  promedio_event_".($i+1);

        }

        $sql.= "(";
        for ($i=0; $i < $numEvents ; $i++) { 
            $sql.= "sumatoria_event_".$i."";
            if (($i+1) < $numEvents) {
              $sql.="+";
            }
        }

        $sql.=") sumatoria_total, ";

        $sql.= "ROUND((";
        for ($i=0; $i < $numEvents ; $i++) { 
            $sql.= "sumatoria_event_".$i."";
            if (($i+1) < $numEvents) {
              $sql.="+";
            }
        }

        $sql.=") sumatoria_total, "

        $sql.= " FROM city, ";

        
        //add froms
        //events
        for ($i=0; $i < $numEvents ; $i++) { 
          //judges
          for ($j=0; $j < $numJudges ; $j++) { 
              $sql.= "( SELECT score.city_id, SUM(score.`value`) sum_score FROM score WHERE score.user_id = ".$idJudges[$j]."  and score.event_id = ".$idEvents[$i]." GROUP BY score.city_id ) juez_".($j+1)."_event_".($i+1)." ";
              if (($j+1) < $numJudges) {
                 $sql.=",";
              }
          }

          if (($i+1) < $numEvents) {
              $sql.=",";
          }
        }

        

         //add wheres
        $sql.= " WHERE ";

        for ($i=0; $i < $numEvents ; $i++) {
          for ($j=0; $j < $numJudges ; $j++) { 
              $sql.= " city.id = juez_".($j+1)."_event_".($i+1).".city_id ";
              if (($j+1) < $numJudges) {
                $sql.="AND";
              }
          }
          
          if (($i+1) < $numEvents) {
                $sql.="AND";
          }
        }

         $sql.= "ORDER BY city.`name` ASC";

        dd($sql);


    }
}

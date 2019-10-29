<?php
namespace App\Repository;

use App\RepositoryInterface\ScoreRepositoryInterface;
use App\Repository\EventRepository;
use App\Score;
use App\User;
use DB;
use Schema;
/**
 * 
 */
class ScoreRepository implements ScoreRepositoryInterface
{

	public function enum($params = null)
	{
		return Score::all();
	}

	public function find($id)
	{
		return Score::find($id);
	}

	public function save($data)
	{
		$score = new Score();
		$score->fill($data);
		if ($score->save()) {			
			$scoreId = $score->getKey();
			return $this->find($scoreId);
		}
	}

	public function edit($id, $data)
	{
		$score = $this->find($id);
		if ($score) {
			$score->fill($data);
			if ($saved = $score->update()) {
				$scoreId = $score->getKey();
				return $this->find($scoreId);
			}
		}
		return false;
	}

	public function remove($id)
	{
		$score = $this->find($id);
		if ($score) {
			if($score->delete()){
				return true;
			}
			return false;

		}
	}


	public function reset()
	{
		DB::table('score')->delete();
		
		$sql = "INSERT INTO score (city_id,user_id,event_id,`value`) (SELECT a.city_id,b.id,c.id,0  FROM (SELECT city_id FROM miss WHERE state = 1) AS a, 
	     (SELECT id FROM `user` WHERE role = 'juez' AND state = 1) AS b, 
	     (SELECT id FROM `event` WHERE `event`.state = 1) AS c);";

		
		DB::select(DB::raw($sql));
	    
	    $eventRepo = (new EventRepository())->getActives();
	    $numEvents = count($eventRepo->toArray());
	    $idEvents = [];
	    foreach ($eventRepo as $key => $event) {
	        $idEvents[$key] =  $event->id;
	    }

	    $judges = (new User())->getJudges();
	    $numJudges = count($judges->toArray());
	    $idJudges = [];
	     
	    foreach($judges as $key =>  $judge){
	       $idJudges[$key] = $judge->id;
	    }

	    for ($j=0; $j < $numJudges; $j++) { 
	    	$sql= " ";
	    	for ($i=0; $i < $numEvents ; $i++) { 
	    		$sql= "DROP VIEW IF EXISTS ju".($j+1)."ev".($i+1).";  ";
	    		DB::statement($sql);
	    	}
	    }
	    

	    // DB::statement($sql);

	    //create views
	    $sql =" ";
	    for ($j=0; $j < $numJudges; $j++) { 
	    	for ($i=0; $i < $numEvents ; $i++) { 
	    		$sql= "CREATE VIEW `ju".($j+1)."ev".($i+1)."` AS SELECT score.city_id as idcanton, score.value as scoreval from score where (score.user_id = ".$idJudges[$j]." ) AND (score.event_id =  ".$idEvents[$i]." ); ";
				DB::statement($sql);
	    	}
	    }

	    
		
		return true;
	}


	public function getSemifinalist()
	{
		$semifinalists = Score::getScore(null,'semifinalist');

		$citiesSemifinalists = '';

		for ($i=0; $i < count($semifinalists) ; $i++) { 
			$citiesSemifinalists.= "'". $semifinalists[$i]->name ."'";
			if( ($i + 1 ) < count($semifinalists) ) $citiesSemifinalists.=',';
		}
		
		return $citiesSemifinalists; 
		

	}

}
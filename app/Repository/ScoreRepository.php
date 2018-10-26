<?php
namespace App\Repository;

use App\RepositoryInterface\ScoreRepositoryInterface;
use App\Score;
use DB;
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
		
		
		return true;
	}

}
<?php
namespace App\Repository;

use App\RepositoryInterface\ScoreRepositoryInterface;
use App\Score;

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

}
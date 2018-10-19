<?php
namespace App\Repository;

use App\RepositoryInterface\MissRepositoryInterface;
use App\Miss;

/**
 * 
 */
class MissRepository implements MissRepositoryInterface
{


	public function enum($params = null)
	{
		return Miss::all();
	}

	public function find($id)
	{
		return Miss::find($id);
	}

	public function save($data)
	{
		$miss = new Miss();
		$miss->fill($data);
		if ($miss = $miss->save()) {
			$missId = $miss->getKey();
			return $this->find($missId);
		}
	}

	public function edit($id, $data)
	{
		$miss = $this->find($id);
		if ($miss) {
			$miss->fill($data);
			if ($miss = $miss->save()) {
				$missId = $miss->getKey();
				return $this->find($missId);
			}
		}
	}

	public function remove($id)
	{
		$miss = $this->find($id);
		if ($miss) {
			if($miss->delete()){
				return true;
			}
			return false;

		}
	}

}
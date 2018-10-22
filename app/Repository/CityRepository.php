<?php
namespace App\Repository;

use App\RepositoryInterface\CityRepositoryInterface;
use App\City;

/**
 * 
 */
class CityRepository implements CityRepositoryInterface
{


	public function getActives()
	{
		return City::where('state',1)->orderBy('name','asc')->get();
	}

	
	public function enum($params = null)
	{
		return City::orderBy('name','asc')->get();
	}

	public function find($id)
	{
		return City::find($id);
	}

	public function save($data)
	{
		$city = new City();
		$city->fill($data);
		if ($city->save()) {			
			$cityId = $city->getKey();
			return $this->find($cityId);
		}
	}

	public function edit($id, $data)
	{
		$city = $this->find($id);
		if ($city) {
			$city->fill($data);
			if ($saved = $city->update()) {
				$cityId = $city->getKey();
				return $this->find($cityId);
			}
		}
		return false;
	}

	public function remove($id)
	{
		$city = $this->find($id);
		if ($city) {
			if($city->delete()){
				return true;
			}
			return false;

		}
	}

}
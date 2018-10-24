<?php
namespace App\Repository;

use App\RepositoryInterface\MissRepositoryInterface;
use App\Miss;
use Image;

/**
 * 
 */
class MissRepository implements MissRepositoryInterface
{


	public function paginate()
	{
		return Miss::select('miss.*')->leftJoin('city','miss.city_id','=','city.id')->where('miss.state',1)->orderBy('city.name','asc')->paginate(1);
	}

	public function count()
	{
		return Miss::select('miss.*')->leftJoin('city','miss.city_id','=','city.id')->where('miss.state',1)->orderBy('city.name','asc')->count();
	}

	public function enum($params = null)
	{
		return Miss::leftJoin('city','miss.city_id','=','city.id')->orderBy('city.name','asc')->get();
		
	}

	public function find($id)
	{
		return Miss::find($id);
	}

	public function save($data)
	{
		$miss = new Miss();

		if (array_key_exists('photos', $data)) {
			$photos = $data['photos'];
			$data['photos'] = $this->uploadPhoto($photos);
		}

		$miss->fill($data);
		if ($saved = $miss->save()) {
			$missId = $miss->getKey();
			return $this->find($missId);
		}
	}

	public function edit($id, $data)
	{
		$miss = $this->find($id);
		if ($miss) {
			if (array_key_exists('photos', $data)) {
				$photos = $data['photos'];
				$data['photos'] = $this->uploadPhoto($photos);
			}
			$miss->fill($data);
			if ($saved = $miss->save()) {
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


	public function uploadPhoto($photo)
	{
		if ($photo->isValid()) {
			
			$realPath = $photo->getRealPath();
			$image = Image::make($realPath);
			$isLandScape = true;
			
			$image->resize(509,682,function($constraint){
				$constraint->aspectRatio();
			});

			$imageName = str_random().'.'. $photo->getClientOriginalExtension();
			if($image->save($this->pathUplod().'/'.$imageName)){
				return 'uploads/'.date('Y').'/'.$imageName;
			}
		}
	}

	private function pathUplod() {
		return public_path().'/uploads/'.date('Y').'/';
	}


}
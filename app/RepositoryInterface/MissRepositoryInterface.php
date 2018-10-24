<?php
namespace  App\RepositoryInterface;

interface  MissRepositoryInterface extends CoreRepositoryInterface {
	
	public function paginate();

	public function count();


}
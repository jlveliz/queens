<?php
namespace  App\RepositoryInterface;

interface  EventRepositoryInterface extends CoreRepositoryInterface {
	
	public function getActives();

	public function getCurrentName();
	
}
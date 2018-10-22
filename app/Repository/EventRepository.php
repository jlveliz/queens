<?php
namespace App\Repository;

use App\RepositoryInterface\EventRepositoryInterface;
use App\Event;

/**
 * 
 */
class EventRepository implements EventRepositoryInterface
{


	public function getActives()
	{
		return Event::where('state',1)->get();
	}

	public function getCurrent()
	{
		$eventModel = new Event();
		return $eventModel->getCurrent();
	}

	
	public function enum($params = null)
	{
		return Event::all();
	}

	public function find($id)
	{
		return Event::find($id);
	}

	public function save($data)
	{
		$event = new Event();
		$event->fill($data);
		if ($event->save()) {			
			$eventId = $event->getKey();
			return $this->find($eventId);
		}
	}

	public function edit($id, $data)
	{
		$event = $this->find($id);
		if ($event) {
			$event->fill($data);
			if ($saved = $event->update()) {
				$eventId = $event->getKey();
				return $this->find($eventId);
			}
		}
		return false;
	}

	public function remove($id)
	{
		$event = $this->find($id);
		if ($event) {
			if($event->delete()){
				return true;
			}
			return false;

		}
	}

}
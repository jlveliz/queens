<?php
namespace App\Repository;

use App\RepositoryInterface\UserRepositoryInterface;
use App\User;

/**
 * 
 */
class UserRepository implements UserRepositoryInterface
{


	public function enum($params = null)
	{
		return User::orderBy('username','asc')->get();
	}

	public function find($id)
	{
		return User::find($id);
	}

	public function save($data)
	{
		$user = new User();
		$data['password'] = \Hash::make($data['password']);
		$user->fill($data);
		if ($user->save()) {			
			$userId = $user->getKey();
			return $this->find($userId);
		}
	}

	public function edit($id, $data)
	{
		$user = $this->find($id);
		if ($user) {
			if(!empty($data['password'])) {
				// dd($data['password']);
				$data['password'] = \Hash::make($data['password']);
				$user->password = $data['password']; 
   			}else {
   				$data['password'] = $user->password;
   			}
			$user->fill($data);
			if ($saved = $user->update()) {
				$userId = $user->getKey();
				return $this->find($userId);
			}
		}
		return false;
	}

	public function remove($id)
	{
		$user = $this->find($id);
		if ($user) {
			if($user->delete()){
				return true;
			}
			return false;

		}
	}

}
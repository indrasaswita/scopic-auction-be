<?php

namespace App\Http\Repositories;

use App\Models\User;

class UserRepository {

	public function __construct() {
		$this->user = new User();
	}

	public function findUserByKey($key){
		$user = $this
			->user
			->where('userkey', 'LIKE', $key)
			->first();

		return $user;
	}

	public function findUserById($user_id){
		$user = $this
			->user
			->find($user_id);

		return $user;
	}

}
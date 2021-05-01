<?php

namespace App\Http\Repositories;

use App\Models\User;
use DB;

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

	public function transferFunds($from, $to, $amount){
		// access DB from RAW query 
		// because eloquent will take more time
		// for security reason: the function is only called by CRON Job
		DB::unprepared("
			UPDATE users
			SET fund = fund - ".$amount."
			WHERE id = ".$from.";

			UPDATE users
			SET fund = fund + ".$amount."
			WHERE id = ".$to.";
		");
	}

}
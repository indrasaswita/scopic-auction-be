<?php

namespace App\Http\Services;

use Illuminate\Http\Request;
use App\Http\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Reply;

class UserService {

	public function __construct () {
		$this->userRepo = new UserRepository();
	}

	public function doLogin(Request $request){
		$userkey = $request->userkey;
		$password = $request->password;

		$user = $this
			->userRepo
			->findUserByKey($userkey);

		if($user == null){
			return Reply::do(false, 'User not found', null, __FUNCTION__);
		}

		$user->makeVisible(['password']);
		$db_password = $user->password;
		$a = Hash::make($password);

		if(Hash::check($password, $db_password)){
			$token = Auth::tokenById($user->id);
			$user->makeHidden(['password']);

			return Reply::do(true, 'Success', [
				'token' => $token,
				'user' => $user,
			], __FUNCTION__);
		}else{
			return Reply::do(false, 'Password is not match', null, __FUNCTION__);
		}
	}

}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\UserService;

class UserController extends Controller
{
	public function __construct(){
		$this->userServ = new UserService();
	}

	public function login(Request $request) {
		$rules = [
			'userkey' => 'required|string',
			'password' => 'required|string',
		];
		$customMessages = [];
		$customAttributes = [];
		$request
			->validate($rules, $customMessages, $customAttributes);

		return $this
			->userServ
			->doLogin($request);
	}


}

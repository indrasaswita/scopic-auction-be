<?php

namespace App\Http\Services;

use Reply;
use Carbon\Carbon;

class TimeService {

	public function __construct() {

	}

	public function getCurrentTime() {
		return Reply::do(true, 'Success', ['current_time' => Carbon::now()], __FUNCTION__);
	}

}
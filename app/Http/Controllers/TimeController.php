<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\TimeService;

class TimeController extends Controller
{

	public function __construct() {
		$this->timeServ = new TimeService();
	}

	public function getCurrentTime(){
		return $this->timeServ->getCurrentTime();
	}
}

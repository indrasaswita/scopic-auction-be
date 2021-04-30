<?php


namespace App\Http\Utilities;

class ReplyUtility {
	public static function do($status, $message, $data, $function=null, $error_code=200){
		return response([
			"status" => $status,
			"message" => $message,
			"data" => $data,
		], $error_code);
	}
}
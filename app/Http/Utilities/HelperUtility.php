<?php

namespace App\Http\Utilities;

class HelperUtility {
	
	public static function arrayObjectToArrayId($data, $index=null){
		$result = [];
		foreach ($data as $i => $ii) {
			if($ii != null){
				if($index == null){
					if($ii->id != null)
						array_push($result, $ii->id);
				}else{
					if($ii[$index] != null)
						array_push($result, $ii[$index]);
				}
			}
		}

		return $result;
	}

}
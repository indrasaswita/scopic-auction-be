<?php

namespace App\Http\Services;

use Carbon\Carbon;
use App\Http\Repositories\ItemRepository;
use App\Http\Repositories\UserRepository;


class SchedulerService {

	public function __construct() {
		$this->itemRepo = new ItemRepository();
		$this->userRepo = new UserRepository();
	}

	public function checkSoldItems(){

		$items = $this->itemRepo
			->getItemByStatuses(['Active']);

		$nowtime = Carbon::now();
		foreach ($items as $i => $ii) {
			$auctionend_at = Carbon::parse($ii->auctionend_at);
			if($auctionend_at < $nowtime){
				$this->itemRepo
					->itemSetSold(['item_id' => $ii->id]);

				$this->userRepo
					->transferFunds($ii->endbid_by, $ii->created_by, $ii->endbidamount);

				echo "Change item id: ".$ii->id." status to Sold.\n";
			}
		}

	}

}
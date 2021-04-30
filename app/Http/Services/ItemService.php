<?php

namespace App\Http\Services;

use Illuminate\Http\Request;
use App\Http\Repositories\ItemRepository;
use App\Http\Repositories\UserRepository;
use App\Events\BidEvent;
use Illuminate\Support\Facades\Auth;
use Reply;

class ItemService {

	public function __construct() {
		$this->itemRepo = new ItemRepository();
		$this->userRepo = new UserRepository();
	}

	public function getAllItemsFiltered(Request $request) {
		$data = [
			'name' => $request->name,
			'paginate' => $request->exists('paginate') ? $request->paginate : env('DEFAULT_PAGINATE', 10),
		];

		$items = $this
			->itemRepo 
			->getItemFiltered($data);

		return Reply::do(true, "Success", ['items' => $items], __FUNCTION__);
	}

	public function getAllItemcategories(Request $request) {
		$itemcategories = $this
			->itemRepo
			->getItemcategoryAll();

		return Reply::do(true, "Success", ['itemcategories' => $itemcategories], __FUNCTION__);
	}

	public function getItemPostedWhenLogin(Request $request) {
		$user = Auth::user();
		$items = $this
			->itemRepo
			->getPostedItem($user->id);

		return Reply::do(true, "Success", [
			'items' => $items
		], __FUNCTION__);
	}

	public function getItemWhenLogin(Request $request) {
		$user = Auth::user();

		$data = [
			'user_id' => $user->id,
			'paginate' => $request->exists('paginate') ? $request->paginate: env('DEFAULT_PAGINATE', 10),
		];

		$temp = $this->itemRepo
			->getCurrentBidItem($data); // not paginated
		$currently_bid = $temp['items'];
		$data['item_ids'] = $temp['item_ids'];
		$currently_not_bid = $this->itemRepo
			->getItemFromNotInIds($data);

		return Reply::do(true, 'Success', [
			'items_current' => $currently_bid,
			'items_notcurrent' => $currently_not_bid,
		], __FUNCTION__);
	}

	public function getItemDetail(Request $request){
		$data = [
			'item_id' => $request->item_id,
		];

		$item = $this->itemRepo
			->getItemDetail($data);

		return Reply::do(true, 'Success', [
			'item' => $item,
		], __FUNCTION__);
	}

	public function bidItem(Request $request) {
		$user = Auth::user();

		$data = [
			'item_id' => $request->item_id,
			'user_id' => $user->id,
			'bidamount' => $request->bidamount,
		];

		// in Repository, we also prevent if the situation create:
		// 1. the same ammount request 
		// 2. for the same item_id 
		// 3. at THE SAME TIME
		// it would return 2 in result[0]
		$itemuser = $this->itemRepo
			->bidItem($data);

		if($itemuser[0] == 0){
			return Reply::do(false, 'Failed. The item has not found. Try to refresh page!', null, __FUNCTION__);
		}else if($itemuser[0] == 1){
			return Reply::do(false, 'Failed. Try bid more than '.$itemuser[1].'!', ['lastbid' => $itemuser[1]], __FUNCTION__);
		}else if($itemuser[0] == 2){
			// exists, if the duplicate request is in the same time.
			return Reply::do(false, 'Failed. Someone has bid this with the same amount ('.$bidamount.') with you. Try bid bigger!', ['lastbid' => $bidamount], __FUNCTION__);
		}else if($itemuser[0] == 3){
			// if successful insert itemusers and update the items
			// call broadcast channel
			$user = $this->userRepo
				->findUserById($itemuser[1]->user_id);
			$bidevent = new BidEvent($itemuser[1], $user);
			event($bidevent);
		}

		return Reply::do(true, 'Success', [
			'itemuser' => $itemuser[1],
		], __FUNCTION__);
	}

}
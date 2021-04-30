<?php

namespace App\Http\Repositories;

use Illuminate\Database\QueryException;
use App\Models\Item;
use App\Models\Itemcategory;
use App\Models\Itemuser;
use Helper;

class ItemRepository {

	public function __construct() {
		$this->item = new Item();
		$this->itemcategory = new Itemcategory();
		$this->itemuser = new Itemuser();
	}

	public function getItemById($id) {
		$item = $this->item
			->find($id);

		return $item;
	}

	public function getItemFiltered($data) {
		$items = $this->item
			->with('itemcategory')
			->where('name', 'LIKE', '%'.$data['name'].'%')
			->paginate($data['paginate']);

		return $items;
	}

	public function getItemcategoryAll() {
		$itemcategories = $this->itemcategory
			->all();

		return $itemcategories;
	}

	public function getPostedItem($user_id) {
		$items = $this
			->item
			->where('created_by', $user_id)
			->orderBy('id', 'DESC')
			->paginate();

		return $items;
	}

	public function getCurrentBidItem($data){
		$item_ids_raw = $this
			->itemuser
			->where('user_id', $data['user_id'])
			->select('item_id as id')
			->get();

		$item_ids = Helper::arrayObjectToArrayId($item_ids_raw);
		// FIND all item_ids first, to create the process faster 
		// than when we use whereHas function eloquent

		$items = $this
			->item
			->whereIn('id', $item_ids)
			->orderBy('id', 'DESC')
			->get();

		return [
			'item_ids' => $item_ids,
			'items' => $items,
		];
	}

	public function getItemFromNotInIds($data) {
		$items = $this
			->item
			->whereNotIn('id', $data['item_ids'])
			->orderBy('id', 'DESC')
			->paginate($data['paginate']);

		return $items;
	}

	public function getItemDetail($data) {
		$item = $this->item
			->where('id', $data['item_id'])
			->with([
				'itemcategory', 
				'itemusers' => function ($q) {
					// the latest transaction would be shown first
					$q->orderBy('created_at', 'DESC');
				}
			])
			->first();

		return $item;
	}

	public function bidItem($data){
		$item = $this->item->find($data['item_id']);
		if($item == null) return [0, null]; // notfound
		else if($item->endbidamount >= $data['bidamount'])
			return [1, $item->endbidamount]; // more than equal than latest

		try{
			$result = $this->itemuser
				->create($data);

			$this->item
				->where('id', $data['item_id'])
				->update([
					'endbidamount' => $data['bidamount'],
					'endbid_by' => $data['user_id'],
				]); // updating
		}catch(QueryException $e){
			return [2, null]; // maybe: duplicated ammount with other user
		}

		return [3, $result]; // success
	}

}
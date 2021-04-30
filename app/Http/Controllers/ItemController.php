<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\ItemService;

class ItemController extends Controller
{

	public function __construct(){
		$this->itemServ = new ItemService();
	}

	public function getAllItemsFiltered(Request $request) {
		$rules = [
			'name' => 'nullable|string',
		];
		$customMessages = [];
		$customAttributes = [];
		$request
			->validate($rules, $customMessages, $customAttributes);

		return $this->itemServ
			->getAllItemsFiltered($request);
	}

	public function getAllItemcategories(Request $request) {
		$rules = [
		];
		$customMessages = [];
		$customAttributes = [];
		$request
			->validate($rules, $customMessages, $customAttributes);

		return $this->itemServ
			->getAllItemcategories($request);
	}

	public function getItemPostedWhenLogin(Request $request) {
		$rules = [
			'paginate' => 'nullable|integer'
		];
		$customMessages = [];
		$customAttributes = [];
		$request
			->validate($rules, $customMessages, $customAttributes);

		return $this->itemServ
			->getItemPostedWhenLogin($request);
	}

	public function getItemWhenLogin(Request $request) {
		$rules = [
			'paginate' => 'nullable|integer'
		];
		$customMessages = [];
		$customAttributes = [];
		$request
			->validate($rules, $customMessages, $customAttributes);

		return $this->itemServ
			->getItemWhenLogin($request);
	}

	public function getItemDetail(Request $request) {
		$rules = [
			'item_id' => 'required|integer|exists:items,id'
		];
		$customMessages = [];
		$customAttributes = [];
		$request
			->validate($rules, $customMessages, $customAttributes);

		return $this->itemServ
			->getItemDetail($request);
	}

	public function bidItem(Request $request) {
		$rules = [
			'item_id' => 'required|integer|exists:items,id',
			'bidamount' => 'required|integer',
		];
		$customMessages = [];
		$customAttributes = [];
		$request
			->validate($rules, $customMessages, $customAttributes);

		return $this->itemServ
			->bidItem($request);
	}

}

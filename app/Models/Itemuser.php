<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Itemuser extends Model
{
	use HasFactory;

	protected $fillable = ['item_id', 'user_id', 'bidamount', 'created_at', 'updated_at'];
	protected $guarded = ['id'];
	protected $dates = ['created_at', 'updated_at'];

	public function item(){
		return $this->belongsTo(Item::class)
			->with('itemcategory');
	}

	public function user(){
		return $this->belongsTo(User::class);
	}


}

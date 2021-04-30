<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
	use HasFactory;

	protected $fillable = ['itemcategory_id', 'name', 'description', 'imageurl', 'startbidamount', 'endbidamount', 'endbid_by', 'status', 'created_by', 'created_at', 'updated_at'];
	protected $guarded = ['id'];
	protected $dates = ['created_at', 'updated_at'];

	public function itemcategory(){
		return $this->belongsTo(Itemcategory::class);
	}

	public function itemusers(){
		return $this->hasMany(Itemuser::class)
			->with('user');
	}

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Itemcategory extends Model
{

	use HasFactory;
	protected $fillable = ['name', 'iconstring', 'created_at', 'updated_at'];
	protected $guarded = ['id'];
	protected $dates = ['created_at', 'updated_at'];
	protected $hidden = ['created_at', 'updated_at'];

	public function items(){
		return $this->hasMany(Item::class);
	}

}

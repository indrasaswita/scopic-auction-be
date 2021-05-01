<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Alteritem extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::unprepared("
			ALTER TABLE items
			ADD COLUMN auctionend_at TIMESTAMP NULL COMMENT 'used for countdown timer' AFTER imageurl;
		");
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
	}
}

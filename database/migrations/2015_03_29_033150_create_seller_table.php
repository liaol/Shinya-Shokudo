<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSellerTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('seller', function(Blueprint $table)
		{
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->timestamps();
			$table->string('name');
			$table->string('phone');
			$table->string('remark');//备注
			$table->integer('delivery_time');//1为all 2为午餐 3为晚餐
			$table->string('status');//1为正常 2为暂停 3为删除
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('seller');
	}

}

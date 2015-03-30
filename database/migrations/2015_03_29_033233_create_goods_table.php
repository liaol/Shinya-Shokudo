<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoodsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('goods', function(Blueprint $table)
		{
            $table->engine = 'InnoDB';
		$table->increments('id');
			$table->timestamps();
			$table->integer('seller_id');
			$table->double('price',10,1);
			$table->integer('count');//售出数量
			$table->string('status');
			
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('goods');
	}

}

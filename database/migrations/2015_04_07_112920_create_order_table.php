<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('order', function(Blueprint $table)
		{
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->integer('user_id');
			$table->integer('seller_id');
			$table->integer('goods_id');
			$table->integer('quantity');//数量
			$table->double('money',10,1);
			$table->integer('pay_type');//支付方式 1为自付 2为公司付
			$table->integer('time_type');//1为午餐 2为晚餐
			$table->integer('status');//1为未审核，2为审核通过，3为审核未通过，4为已删除
            $table->string('remark');//备注
            $table->index('user_id');
            $table->index('seller_id');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('order');
	}

}

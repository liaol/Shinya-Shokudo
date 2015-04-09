<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('users', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('real_name');
			$table->string('email');
			$table->string('password', 60);
			$table->string('name')->unique();
			$table->string('qq');
			$table->double('money',10,1);
			$table->integer('level');//用户类型
			$table->integer('department_id');//部门id
			$table->rememberToken();
			$table->integer('status');
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
		Schema::drop('users');
	}

}

<?php

use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	public function up()
	{
	    Schema::create('users', function($table)
	    {
	        $table->increments('id');
	        $table->string('email')->nullable(); //nullable for twitter
	        $table->string('photo');
	        $table->string('name');
	        $table->string('password');
	        $table->timestamps();
			$table->text('remember_token')->nullable();
	    });
	}

	public function down()
	{
	    Schema::drop('users');
	}

}
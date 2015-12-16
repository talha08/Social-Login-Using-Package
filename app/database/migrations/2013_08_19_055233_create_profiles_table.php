<?php

use Illuminate\Database\Migrations\Migration;

class CreateProfilesTable extends Migration {

	public function up()
	{
	    Schema::create('profiles', function($table)
	    {
	        $table->increments('id');
			$table->string('username');
	        $table->string('gender')->nullable();
	        $table->string('uid');
	        $table->string('access_token');
	        $table->string('access_token_secret');
	        $table->timestamps();

			$table->integer('user_id')->unsigned();
			$table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');

	    });
	}

	public function down()
	{
	    Schema::drop('profiles');
	}

}
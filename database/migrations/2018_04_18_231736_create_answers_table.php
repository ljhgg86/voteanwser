<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnswersTable extends Migration
{
	public function up()
	{
		Schema::create('answers', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('vote_id')->unsigned()->index()->comment('投票条目ID');
            $table->integer('option_id')->unsigned()->index()->comment('投票选项ID');
            $table->timestamps();
        });
	}

	public function down()
	{
		Schema::drop('answers');
	}
}

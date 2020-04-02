<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserVotesTable extends Migration
{
	public function up()
	{
		Schema::create('user_votes', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('vote_id')->unsigned()->index()->comment('投票条目ID');
            $table->integer('option_id')->unsigned()->index()->comment('投票选项ID');
            $table->integer('user_id')->unsigned()->index()->comment('投票选项ID');
            $table->boolean('correct')->default(false)->comment('答对标志');
            $table->timestamps();
        });
	}

	public function down()
	{
		Schema::drop('user_votes');
	}
}

<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRewardItemsTable extends Migration 
{
	public function up()
	{
		Schema::create('reward_items', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('reward_id')->unsigned()->index()->comment('抽奖ID');
            $table->integer('poll_id')->unsigned()->index()->comment('投票ID');
            $table->integer('vote_id')->unsigned()->index()->comment('投票条目ID');
            $table->timestamps();
        });
	}

	public function down()
	{
		Schema::drop('reward_items');
	}
}

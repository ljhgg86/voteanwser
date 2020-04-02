<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRankinglistsTable extends Migration
{
	public function up()
	{
		Schema::create('rankinglists', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->index()->comment('用户ID');
            $table->integer('poll_id')->unsigned()->index()->comment('投票ID');
            $table->integer('correct_num')->default(0)->comment('答对条数');
            $table->timestamp('last_correct_time')->comment('最新一次答对时间');
            $table->timestamps();
        });
	}

	public function down()
	{
		Schema::drop('rankinglists');
	}
}

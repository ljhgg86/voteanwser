<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRewardLogsTable extends Migration
{
	public function up()
	{
		Schema::create('reward_logs', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('reward_id')->unsigned()->index()->comment('抽奖ID');
            $table->integer('user_id')->unsigned()->index()->comment('用户ID');
            $table->string('reward_type')->index()->comment('奖项');
            $table->integer('reward_count')->comment('中奖人数');
            $table->string('remark')->nullable()->comment('备注');
            $table->timestamps();
        });
	}

	public function down()
	{
		Schema::drop('reward_logs');
	}
}

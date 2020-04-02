<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRewardRecordsTable extends Migration
{
	public function up()
	{
		Schema::create('reward_records', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('reward_id')->unsigned()->index()->comment('抽奖ID');
            $table->integer('user_id')->unsigned()->index()->comment('用户ID');
            $table->string('reward_type')->index()->comment('奖项');
            $table->string('redeem_code')->nullable()->comment('兑奖验证码');
            $table->boolean('redeemflag')->default(false)->comment('兑奖标志');
            $table->datetime('redeem_at')->nullable()->comment('兑奖时间');
            $table->boolean('sendsms_flag')->default(false)->comment('发送中奖短信标志');
            $table->datetime('sendsms_at')->nullable()->comment('发送中奖短信时间');
            $table->boolean('delflag')->default(false)->comment('删除标志');
            $table->string('remark')->nullable()->comment('兑奖备注');
            $table->timestamps();
        });
	}

	public function down()
	{
		Schema::drop('reward_records');
	}
}

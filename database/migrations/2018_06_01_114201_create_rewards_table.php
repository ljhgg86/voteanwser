<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRewardsTable extends Migration 
{
	public function up()
	{
		Schema::create('rewards', function(Blueprint $table) {
            $table->increments('id');
            $table->string('title')->index()->comment('抽奖标题');
            $table->text('description')->nullable()->comment('抽奖描述');
            $table->integer('condition')->unsigned()->default(0)->comment('答对条数');
            $table->boolean('delflag')->default(false)->comment('删除标志');
            $table->timestamps();
        });
	}

	public function down()
	{
		Schema::drop('rewards');
	}
}

<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVoteInfoTable extends Migration
{
	public function up()
	{
		Schema::create('votesinfo', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('vote_id')->unsigned()->index()->comment('用户ID');
            $table->string('info')->comment('投票对象信息');
            $table->string('thumbnail')->nullable()->comment('缩略图');
            $table->timestamps();
        });
	}

	public function down()
	{
		Schema::drop('votesinfo');
	}
}

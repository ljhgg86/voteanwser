<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePollsTable extends Migration 
{
	public function up()
	{
		Schema::create('polls', function(Blueprint $table) {
            $table->increments('id');
            $table->string('title')->index()->comment('投票标题');
            $table->string('thumbnail')->nullable()->comment('投票缩略图');
            $table->text('description')->nullable()->comment('描述');
            $table->text('rules')->nullable()->comment('规则');
            $table->integer('category_id')->unsigned()->index()->comment('分类ID');
            $table->integer('vote_count')->unsigned()->default(0)->comment('参加人数');
            $table->boolean('show_votecount')->default(true)->comment('显示参加人数标志');
            $table->integer('createuser_id')->unsigned()->comment('创建人');
            $table->integer('verifyuser_id')->unsigned()->nullable()->comment('审核人');
            $table->boolean('verifyflag')->default(false)->comment('审核标志');
            $table->boolean('endflag')->default(false)->comment('结束标志');
            $table->boolean('delflag')->default(false)->comment('删除标志');
            $table->timestamps();
        });
	}

	public function down()
	{
		Schema::drop('polls');
	}
}

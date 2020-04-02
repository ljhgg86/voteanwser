<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVotesTable extends Migration 
{
	public function up()
	{
		Schema::create('votes', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('poll_id')->unsigned()->index()->comment('投票ID');
            $table->string('title')->index()->comment('投票标题');
            $table->string('thumbnail')->nullable()->comment('投票缩略图');
            $table->datetime('start_at')->comment('开始时间');
            $table->datetime('end_at')->nullable()->comment('结束时间');
            $table->datetime('view_end_at')->nullable()->comment('结束后观看结果时间');
            $table->integer('option_count')->unsigned()->default(1)->comment('选项个数');
            $table->integer('option_type')->unsigned()->default(1)->comment('1单选 2多选');
            $table->integer('vote_type')->unsigned()->default(1)->comment('投票类型1题目 2投票');
            $table->integer('vote_count')->unsigned()->default(0)->comment('投票人数');
            $table->boolean('show_votecount')->default(true)->comment('显示参加人数标志');
            $table->text('description')->nullable()->comment('描述');
            $table->boolean('delflag')->default(false)->comment('删除标志');
            $table->timestamps();
        });
	}

	public function down()
	{
		Schema::drop('votes');
	}
}

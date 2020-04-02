<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOptionsTable extends Migration
{
	public function up()
	{
		Schema::create('options', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('vote_id')->unsigned()->index()->comment('投票条目ID');
            $table->string('option', 500)->index()->comment('选项');
            $table->string('thumbnail', 500)->nullable()->comment('投票缩略图');
            $table->integer('vote_count')->unsigned()->default(0)->comment('投票人数');
            $table->text('description')->nullable()->comment('描述');
            $table->timestamps();
        });
	}

	public function down()
	{
		Schema::drop('options');
	}
}

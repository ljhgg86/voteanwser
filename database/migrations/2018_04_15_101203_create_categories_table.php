<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration 
{
	public function up()
	{
		Schema::create('categories', function(Blueprint $table) {
            $table->increments('id');
            $table->string('title')->index()->comment('标题');
            $table->text('description')->nullable()->comment('描述');
            $table->boolean('delflag')->default('0')->comment('删除标志');
            $table->timestamps();
        });
	}

	public function down()
	{
		Schema::drop('categories');
	}
}

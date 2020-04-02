<?php

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategoriesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('categories')->insert([
            'title' => '体育',
            'description' => '体育',
        ]);

        DB::table('categories')->insert([
            'title' => '法律',
            'description' => '法律',
        ]);
    }

}


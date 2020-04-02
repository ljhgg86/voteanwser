<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'admin',
            'password' => bcrypt('admin123'),
            'nickname' => 'admin',
            'realname' => 'admin',
            'phone' => '10000',
            'user_avatar' => 'admin_avatar',
            'role_id'=>0,
        ]);

        // DB::table('users')->insert([
        //     'name' => 'user',
        //     'password' => bcrypt('user123'),
        //     'nickname' => 'user',
        //     'realname' => 'user',
        //     'phone' => '10086',
        //     'user_avatar' => 'user_avatar',
        // ]);
    }
}

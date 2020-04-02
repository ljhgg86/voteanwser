<?php

use Illuminate\Database\Seeder;
use App\Models\UserVote;
use App\Models\User;

class UserVotesTableSeeder extends Seeder
{
    public function run()
    {
        $users=User::all();
        $users->each(function($user) {
           UserVote::create(['user_id'=>$user->id, 'vote_id'=>1, 'option_id'=>rand(1,3)]);
           UserVote::create(['user_id'=>$user->id, 'vote_id'=>2, 'option_id'=>rand(4,6)]);
        });
    }

}


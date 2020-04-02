<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
		// $this->call(RewardLogsTableSeeder::class);
		// $this->call(RewardRecordsTableSeeder::class);
		// $this->call(RewardItemsTableSeeder::class);
		// $this->call(RewardsTableSeeder::class);
        //$this->call(CategoriesTableSeeder::class);
        //$this->call(PollsTableSeeder::class);
        //$this->call(VoteinfosTableSeeder::class);
        //$this->call(VotesTableSeeder::class);
        //$this->call(RankinglistsTableSeeder::class);
        $this->call(UserVotesTableSeeder::class);
        //$this->call(AnswersTableSeeder::class);
        //$this->call(OptionsTableSeeder::class);
    }
}

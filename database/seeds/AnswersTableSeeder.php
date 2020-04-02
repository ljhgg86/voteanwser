<?php

use Illuminate\Database\Seeder;
use App\Models\Answer;

class AnswersTableSeeder extends Seeder
{
    public function run()
    {
        $answers = factory(Answer::class)->times(50)->make()->each(function ($answer, $index) {
            if ($index == 0) {
                // $answer->field = 'value';
            }
        });

        Answer::insert($answers->toArray());
    }

}


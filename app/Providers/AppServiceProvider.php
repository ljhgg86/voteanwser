<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
	{
		\App\Models\User::observe(\App\Observers\UserObserver::class);
		\App\Models\RewardLog::observe(\App\Observers\RewardLogObserver::class);
		\App\Models\RewardRecord::observe(\App\Observers\RewardRecordObserver::class);
		\App\Models\RewardItem::observe(\App\Observers\RewardItemObserver::class);
		\App\Models\Reward::observe(\App\Observers\RewardObserver::class);
		\App\Models\VoteInfo::observe(\App\Observers\VoteInfoObserver::class);
		\App\Models\Rankinglist::observe(\App\Observers\RankinglistObserver::class);
		\App\Models\UserVote::observe(\App\Observers\UserVoteObserver::class);
		\App\Models\Answer::observe(\App\Observers\AnswerObserver::class);
		\App\Models\Option::observe(\App\Observers\OptionObserver::class);
		\App\Models\Vote::observe(\App\Observers\VoteObserver::class);
		\App\Models\Poll::observe(\App\Observers\PollObserver::class);
		\App\Models\Category::observe(\App\Observers\CategoryObserver::class);

        \Carbon\Carbon::setLocale('zh');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}

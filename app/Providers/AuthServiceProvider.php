<?php

namespace App\Providers;

use Laravel\Passport\Passport;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
		 \App\Models\RewardLog::class => \App\Policies\RewardLogPolicy::class,
		 \App\Models\RewardRecord::class => \App\Policies\RewardRecordPolicy::class,
		 \App\Models\RewardItem::class => \App\Policies\RewardItemPolicy::class,
		 \App\Models\Reward::class => \App\Policies\RewardPolicy::class,
		 \App\Models\VoteInfo::class => \App\Policies\VoteInfoPolicy::class,
		 \App\Models\Rankinglist::class => \App\Policies\RankinglistPolicy::class,
		 \App\Models\UserVote::class => \App\Policies\UserVotePolicy::class,
		 \App\Models\Answer::class => \App\Policies\AnswerPolicy::class,
		 \App\Models\Option::class => \App\Policies\OptionPolicy::class,
		 \App\Models\Vote::class => \App\Policies\VotePolicy::class,
		 \App\Models\Poll::class => \App\Policies\PollPolicy::class,
		 \App\Models\Category::class => \App\Policies\CategoryPolicy::class,
        'App\Model' => 'App\Policies\ModelPolicy',
        \App\Models\User::class  => \App\Policies\UserPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Passport::routes();

        Passport::tokensExpireIn(now()->addDays(10));

        Passport::refreshTokensExpireIn(now()->addDays(30));
    }
}

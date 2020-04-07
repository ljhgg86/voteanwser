<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\Event' => [
            'App\Listeners\EventListener',
        ],
        'App\Events\InputAnswerEvent' => [
            'App\Listeners\InputAnswerEventListener',
        ],
        'App\Events\UserVotedEvent' => [
            'App\Listeners\UserVotedEventListener',
        ],
        'App\Events\RegenerateRankinglistEvent' => [
            'App\Listeners\RegenerateRankinglistEventListener',
        ],
        'App\Events\UserPollEvent' => [
            'App\Listeners\UserPollEventListener',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}

<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

use App\Models\Poll;
use App\Models\User;

class UserPollEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $poll;

    public $user;

    public $correctNum;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Poll $poll, User $user, $correctNum)
    {
        $this->poll = $poll;
        $this->user = $user;
        $this->correctNum = $correctNum;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}

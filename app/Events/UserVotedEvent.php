<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

use App\Models\Vote;
use App\Models\User;

class UserVotedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;


    public $vote;

    public $user;

    public $option_ids;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Vote $vote, User $user, $option_ids)
    {
        $this->vote = $vote;
        $this->user = $user;
        $this->option_ids = $option_ids;
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

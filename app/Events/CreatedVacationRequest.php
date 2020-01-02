<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\VacationRequest;
use App\Models\User;

class CreatedVacationRequest
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $vacation_request;
    public $user;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(VacationRequest $vacation_request, User $user)
    {
        $this->vacation_request = $vacation_request;
        $this->user = $user;
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

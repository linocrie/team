<?php

namespace App\Events;

use App\Models\Profession;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProfessionCreatedOrUpdated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;
    public $beforeProfessions;
    public $updatedProfessions;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($user, $beforeProfessions, $updatedProfessions)
    {
        $this->user = $user;
        $this->beforeProfessions = $beforeProfessions;
        $this->updatedProfessions = $updatedProfessions;
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

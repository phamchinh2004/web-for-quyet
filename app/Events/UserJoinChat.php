<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserJoinChat implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;


    public $username;
    public $full_name;

    public function __construct($username, $full_name)
    {
        $this->username = $username;
        $this->full_name = $full_name;
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel("join.conversation"),
        ];
    }

    public function broadcastAs()
    {
        return 'UserJoinChat';
    }
}

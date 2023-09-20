<?php

namespace App\Events;

use App\Http\Controllers\traid\UserRole;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;


class Shopownersmessage implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels,UserRole;
    public $chatdata;


    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($chatdata)
    {
        //
        $this->chatdata=$chatdata;

    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {        
        return new Channel('shopownersmessage.'.$this->chatdata['shop']['id']);
    }
}

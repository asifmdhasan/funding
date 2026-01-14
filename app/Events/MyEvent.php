<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class MyEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    
    /**
     * Create a new event instance.
     */
    // public $data;
    public $part_name;
    public $stock;

    public function __construct($warehouseStock)
    {
        $data = is_string($warehouseStock->data) ? json_decode($warehouseStock->data, true) : $warehouseStock->data;

        // dd($warehouseStock->part_variant->part->part_name);
        $this->part_name = $warehouseStock->part_variant->part->part_name;
        $this->stock = $warehouseStock->stock;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn()
    {
        return 
            new Channel('my-channel');
    }

    public function broadcastAs()
    {
        return 'my-event';
    }
}

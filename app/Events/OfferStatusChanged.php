<?php

namespace App\Events;

use App\Lot;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OfferStatusChanged implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var Lot
     */
    public $lot;

    /**
     * Create a new event instance.
     *
     * @param  $lot
     */
    public function __construct(Lot $lot)
    {
        $this->lot = $lot;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('lot-change');
    }

    public function broadcastWith(){
        $exstra = [
            'offer_id' => $this->lot->offer->id,
        ];
        return array_merge($this->lot->toArray(), $exstra);
    }


}

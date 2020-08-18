<?php

namespace App\Events;

use App\Lot;
use App\Offer;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OfferStatusChanged implements ShouldBroadcast
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
        return (['lot-change', 'lot-change' . $this->lot->offer->id]);
    }

    public function broadcastWith(){
        $exstra = [
            'offer_id' => $this->lot->offer->id,
        ];
        return array_merge($this->lot->toArray(), $exstra);
    }


}

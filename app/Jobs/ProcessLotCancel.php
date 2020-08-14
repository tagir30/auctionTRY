<?php

namespace App\Jobs;

use App\Lot;
use App\Offer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessLotCancel implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Lot
     */
    private $lot;

    /**
     * @var Offer
     */
    private $offer;

    /**
     * Create a new job instance.
     *
     * @param Lot $lot
     * @param Offer $offer
     */
    public function __construct(Lot $lot, Offer $offer)
    {
        $this->offer = $offer;
        $this->lot = $lot;
    }

    /**
     * Execute the job.
     *
     * @return void
     *
     *
     */
    public function handle()//Возможно стоит сделать составной job
    {
        //тут что-то типо определения победителя
        $this->offer->delete();
        $this->lot->update(['status' => -1]);
    }

}

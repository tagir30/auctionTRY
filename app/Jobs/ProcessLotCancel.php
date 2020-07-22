<?php

namespace App\Jobs;

use App\Lot;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessLotCancel implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $lot;

    /**
     * Create a new job instance.
     *
     * @param Lot $lot
     */
    public function __construct(Lot $lot)
    {
        $this->lot = $lot;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->setTimerForCancel($this->lot);
    }

    private function setTimerForCancel($lot)
    {
        if ($lot->status) {
            $lot->status = 0;
            $lot->update();
        }
    }
}

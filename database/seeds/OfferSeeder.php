<?php

use App\Jobs\ProcessLotCancel;
use App\Lot;
use App\Offer;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class OfferSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $lotsForAuction = Lot::where('status', 1)->get();

        $lotsForAuction->each(function ($lot){
            $deferenceHours = Carbon::create($lot->timeLeft)->diffInHours(now());

            $offer = Offer::create([
                'lot_id' => $lot->id,
                'bet_on_lot' => $lot->startingPrice,
            ]);
            ProcessLotCancel::dispatch($lot, $offer)->delay(now()->addHours($deferenceHours));

        });
    }
}

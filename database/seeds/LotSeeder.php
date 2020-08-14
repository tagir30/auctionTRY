<?php

use App\Lot;
use App\Offer;
use App\User;
use Illuminate\Database\Seeder;

class LotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::first();

        $lot1 = new Lot();
        $lot1->status = 1;
        $lot1->name = 'first lot';
        $lot1->startingPrice = 12000;
        $lot1->description = 'Lot 1 create for test';
        $lot1->timeLeft = now()->addHours(5);
        $lot1->pathImage = config('constants.PATH_DEFAULT_IMAGE');
        $lot1->user_id = $user->id;
        $lot1->save();
        $offer = new Offer([
            'lot_id' => $lot1->id,
            'bet_on_lot' => $lot1->startingPrice,
        ]);
        $lot1->offer()->save($offer);
    }
}

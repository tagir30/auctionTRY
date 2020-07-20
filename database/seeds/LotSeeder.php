<?php

use App\Lot;
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
        $lot1->name = 'first lot';
        $lot1->startingPrice = 12000;
        $lot1->description = 'Lot 1 create for test';
        $lot1->timeLeft = 7;//часов
        $lot1->pathImage = 'undefuned';
        $lot1->user_id = $user->id;
        $lot1->save();
    }
}

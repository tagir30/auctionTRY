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
        $userIds = User::pluck('id');

        $lots = factory(Lot::class, 10)->make()->each(function ($lot) use ($userIds){
            $lot->user_id = $userIds->random();
        })->toArray();

        Lot::insert($lots);
    }
}

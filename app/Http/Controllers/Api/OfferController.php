<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateBetRequest;
use App\Lot;
use App\Offer;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class OfferController extends Controller
{
    public function index()
    {
        $lots = Lot::where('status', 1)->with('offer')->get();
        return response($lots->jsonSerialize(), Response::HTTP_OK);
    }

    public function update(UpdateBetRequest $request, Offer $offer)
    {
        $offer->bet_on_lot = $request->bet_on_lot;
        $offer->user_id_bet = Auth::id();//не работает

        $offer->update();


        return response(null, Response::HTTP_OK);
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Lot;
use App\Offer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class OfferController extends Controller
{
    public function index(){
        $lots = Lot::where('status', 1)->with('offer')->get();
        return response($lots->jsonSerialize(), Response::HTTP_OK);
    }

    public function update(Request $request, Offer $offer){
        $request->validate([
            'bet_on_lot' => 'required|integer|min:1'
        ]);

        $offer->bet_on_lot = $request->bet_on_lot;
        $offer->user_id_bet = Auth::id();
        $offer->update();

        return response(null,Response::HTTP_OK);
    }
}

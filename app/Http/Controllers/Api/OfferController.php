<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\UserIdSameOwner;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateBetRequest;
use App\Lot;
use App\Offer;
use Illuminate\Http\Response;
use mysql_xdevapi\Exception;

class OfferController extends Controller
{
    public function index()
    {
        $lots = Lot::where('status', 1)->with('offer')->get();
        return response($lots->jsonSerialize(), Response::HTTP_OK);
    }

    public function update(UpdateBetRequest $request, Offer $offer)
    {
        $lot_user_id = (Lot::findOrFail($offer->lot_id))->user_id;//для проверки, чтобы сам на свой лот не ставил
        if($lot_user_id == $request->user_id){//Возможно это можно в форм реквест сделать
            abort(403, 'Ставка на свой лот запрещена!');
        }
        $offer->bet_on_lot = $request->bet_on_lot;
        $offer->user_id_bet = $request->user_id;
        $offer->update();

        return response(null, Response::HTTP_OK);
    }

    public function show(Offer $offer)
    {
        $lot = Lot::with('offer')->findOrFail($offer->lot_id);
        return response($lot->jsonSerialize(), Response::HTTP_OK);
    }
}

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
    public function index()
    {
        $lots = Lot::where('status', 1)->with('offer')->get();
        return response($lots->jsonSerialize(), Response::HTTP_OK);
    }

    public function update(Request $request, Offer $offer)
    {
        $request->validate([
            'bet_on_lot' => [
                'required',
                'min:1',
                'integer',
                function($attribute, $value, $fail) use ($offer){
                    if($offer->bet_on_lot > $value){
                        $fail('Ставка должна быть выше прежней');
                    }
                }

            ]

        ],[
            'bet_on_lot.required' => 'Введите ставку!',
            'bet_on_lot.min' => 'Ставка должна быть выше 1 рубля',
        ]);

        $offer->bet_on_lot = $request->bet_on_lot;
        $offer->user_id_bet = Auth::id();//не работает

        $offer->update();


        return response(null, Response::HTTP_OK);
    }
}

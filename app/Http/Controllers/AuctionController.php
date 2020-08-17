<?php

namespace App\Http\Controllers;

use App\Lot;
use App\Offer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AuctionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('auction.main');
    }

    /**
     * Display the specified resource.
     *
     * @param Offer $offer
     * @return Response
     */
    public function show(Offer $offer)
    {
        $lot = Lot::with('offer')->findOrFail($offer->lot_id);
        return view('auction.show', compact('lot'));
    }

}

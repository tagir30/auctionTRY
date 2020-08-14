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
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}

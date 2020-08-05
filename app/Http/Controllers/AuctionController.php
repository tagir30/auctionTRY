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
        $lots = [];

        if (auth()->check()) {
            $lots = Lot::where('user_id', '!=', auth()->id())->where('status', 1)->with('offer')->paginate();//Чтобы не отображать свои лоты
        } else {
            $lots = Lot::where('status', 1)->with('offer')->paginate();
        }
        return view('auction.main', compact('lots'));
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
     * @param int $id
     * @return Response
     */
    public function show($offer)
    {
        $offer = Offer::findOrFail($offer);
        return view('auction.show', compact('offer'));
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

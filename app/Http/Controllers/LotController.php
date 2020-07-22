<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessLotCancel;
use App\Lot;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class LotController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $lots = Lot::paginate(5);
        return view('home', compact('lots'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        Lot::create([
            'name' => $request->lot['nameLot'],
            'description' => $request->lot['description'],
            'startingPrice' => $request->lot['startingPrice'],
            'timeLeft' => $request->lot['timeLeft'],
            'pathImage' => $request->lot['image'],
            'user_id' => Auth::user()->id,
        ]);
        return redirect()->route('lots.index');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $lot = Lot::findOrFail($id);
        $lot->status = 1;
        $lot->update();
        ProcessLotCancel::dispatch($lot)->delay(30);
        return back();
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

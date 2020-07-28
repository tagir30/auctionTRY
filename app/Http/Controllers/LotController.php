<?php

namespace App\Http\Controllers;

use App\Http\Requests\LotRequest;
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
        $lots = Lot::where('user_id', Auth::id())->paginate(5);
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
    public function store(LotRequest $request)
    {

        if ($request->file('lot.image')) {
            $path = $request->file('lot.image')->store('uploads', 'public');
        } else {
            $path = '/uploads/no.jpg';//Как-то это поправить надо...
        }
        Lot::create([
            'name' => $request->lot['nameLot'],
            'description' => $request->lot['description'],
            'startingPrice' => $request->lot['startingPrice'],
            'timeLeft' => $request->lot['timeLeft'],
            'pathImage' => $path,
            'user_id' => Auth::id(),
        ]);
        session()->flash('success_message', 'Лот успешно создан!');
        return redirect()->route('lots.index');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return void
     */
    public function show($id)
    {
        $lot = Lot::findOrFail($id);
        return view('show', compact('lot'));
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

        ProcessLotCancel::dispatch($lot)->delay(now()->addMinutes($lot->timeLeft));
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
     * @return void
     */
    public function destroy($id)
    {
        //
    }
}

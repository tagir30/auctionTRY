<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLotRequest;
use App\Lot;
use App\Service\LotService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class LotController extends Controller
{
    private $lotService;

    public function __construct(LotService $lotService)
    {
        $this->lotService = $lotService;

    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $lots = Lot::where('user_id', Auth::id())->paginate(5);
        return view('lots.home', compact('lots'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('lots.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(StoreLotRequest $request)
    {

        $path = $this->lotService->handleUploadedImage($request->file('lot.image'));
        Lot::create([
            'name' => $request->lot['nameLot'],
            'description' => $request->lot['description'],
            'startingPrice' => $request->lot['startingPrice'],
            'timeLeft' => $request->lot['timeLeft'],
            'pathImage' => $path,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('lots.index')->with('success_message', 'Лот успешно создан!');
    }

    /**
     * Display the specified resource.
     *
     * @param Lot $lot
     * @return void
     * @throws AuthorizationException
     */
    public function show(Lot $lot)
    {
        $this->authorize('view', $lot);
        return view('lots.show', compact('lot'));
    }

    /**
     *
     *
     * @param Lot $lot
     * @return Response
     */
    public function edit(Lot $lot)
    {

        return view('lots.edit', compact('lot'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Lot $lot
     * @return Response
     * @throws AuthorizationException
     */
    public function update(Request $request, Lot $lot)
    {
        $this->authorize('update', $lot);
        $this->lotService->addOrRemoveToAuction($lot);
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Lot $lot
     * @return void
     * @throws AuthorizationException
     */
    public function destroy(Lot $lot)//Дописать условия при нахождения лота на аукционне и т.д
    {
        $this->authorize('delete', $lot);
//        $lot = Lot::findOrFail($id);
//
//        if (Auth::id() === $lot->user_id) {
//            $lot->delete();
//
//            return redirect()->route('lots.index')->with('success_message', 'Лот успешно удалён');
//        }
    }
}

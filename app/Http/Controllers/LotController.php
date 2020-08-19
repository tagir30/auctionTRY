<?php

namespace App\Http\Controllers;

use App\Events\OfferStatusChanged;
use App\Http\Requests\StoreLotRequest;
use App\Http\Requests\UpdateLotRequest;
use App\Lot;
use App\Service\LotService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\MessageBag;

class LotController extends Controller
{
    const ADD_LOT = 'addToAuction';
    const REMOVE_LOT = 'removeFromAuction';

    private $lotService;
    private $paginate = 10;

    /**
     * LotController constructor.
     * @param LotService $lotService
     */
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
        if (request()->sort == 'active') {
            $lots = Lot::getActiveLot()->paginate($this->paginate);
        } elseif (request()->sort == 'end') {
            $lots = Lot::getCompletedLot()->paginate($this->paginate);
        } else {
            $lots = Lot::where('user_id', Auth::id())->paginate($this->paginate);
        }
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
     * @param StoreLotRequest $request
     * @return Response
     */
    public function store(StoreLotRequest $request)
    {
        $this->lotService->store($request);//Стоит передавать реквест, или request() можно использовать...

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
     * @param UpdateLotRequest $request
     * @param Lot $lot
     * @param MessageBag $errors
     * @return Response
     * @throws AuthorizationException
     */
    public function update(UpdateLotRequest $request, Lot $lot, MessageBag $errors)
    {
        $this->authorize('update', $lot);

        if ($lot->status) {
            $errors->add('lotInAuction', 'Лот находиться на аукционе, изменения запрещены!');
        } else {
            $this->lotService->update($lot);
        }

        return redirect()->route('lots.index')->withErrors($errors);
    }


    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function updateStatus(Request $request)
    {
        $lot = Lot::findOrFail($request->lot);

        if ($request->action === self::ADD_LOT) {//или объеденить их elseif?
            $this->lotService->addLotToAuction($lot);
        }

        if ($request->action === self::REMOVE_LOT) {
            $this->lotService->removeLotFromAuction($lot);
        }


        return redirect()->route('lots.index');

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
        Storage::delete('public/' . $lot->pathImage);
        $lot->delete();

        return redirect()->route('lots.index')->with('success_message', 'Лот успешно удалён');
    }
}

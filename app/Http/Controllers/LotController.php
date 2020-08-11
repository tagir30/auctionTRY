<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLotRequest;
use App\Http\Requests\UpdateLotRequest;
use App\Lot;
use App\Service\ImageService;
use App\Service\LotService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class LotController extends Controller
{
    private $lotService;
    private $imageService;

    public function __construct(LotService $lotService, ImageService $imageService)
    {
        $this->imageService = $imageService;
        $this->lotService = $lotService;

    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $lots = Lot::where('user_id', Auth::id())->paginate(10);
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
        //По сути можно вынести в тот же сервис...(конечно можно избавиться от зависимостей), но не станет ли сервис god :D
        $path = $this->imageService->handleUploadedImage($request->file('lot.image'));

        dd(Lot::create([
            'name' => $request->lot['nameLot'],
            'description' => $request->lot['description'],
            'startingPrice' => $request->lot['startingPrice'],
            'timeLeft' => $request->lot['timeLeft'],
            'pathImage' => $path,
            'user_id' => Auth::id(),
        ]));

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
     * @return Response
     * @throws AuthorizationException
     */
    public function update(UpdateLotRequest $request, Lot $lot)//не могу придумать нормальный реквес...
    {//мб стоит отделить выставление на аукцион и update
        $this->authorize('update', $lot);

        $this->lotService->mainSwitch($lot);//как от этого избавиться...
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
//        $lot = Lot::findOrFail($id);
//
//        if (Auth::id() === $lot->user_id) {
//            $lot->delete();
//
//            return redirect()->route('lots.index')->with('success_message', 'Лот успешно удалён');
//        }
    }
}

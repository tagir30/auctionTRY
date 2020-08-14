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
use Illuminate\Support\Facades\Storage;

class LotController extends Controller
{
    private $lotService;

    public function __construct(LotService $lotService )
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


        if(request()->sort == 'active'){
            $lots = Lot::where('user_id', Auth::id())->where('status', 1)->paginate(10);
        }elseif (\request()->sort == 'end'){
            $lots = Lot::where('user_id', Auth::id())->where('status', -1)->paginate(10);
        }else{
            $lots = Lot::where('user_id', Auth::id())->paginate(10);
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
     * @return Response
     * @throws AuthorizationException
     */
    public function update(UpdateLotRequest $request, Lot $lot)
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
        Storage::delete('public/' . $lot->pathImage);
        $lot->delete();

        return redirect()->route('lots.index')->with('success_message', 'Лот успешно удалён');
    }
}

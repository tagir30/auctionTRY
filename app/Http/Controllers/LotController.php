<?php

namespace App\Http\Controllers;

use App\Http\Requests\LotRequest;
use App\Jobs\ProcessLotCancel;
use App\Lot;
use App\Service\LotService;
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
    public function store(LotRequest $request)
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
     * @param int $id
     * @return void
     */
    public function show($id)
    {
        $lot = Lot::findOrFail($id);
        return view('lots.show', compact('lot'));
    }

    /**
     *
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $lot = Lot::findOrFail($id);
        return view('lots.edit', compact('lot'));
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
        $this->lotService->addOrRemoveToAuction($id);
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return void
     */
    public function destroy($id)//Дописать условия при нахождения лота на аукционне и т.д
    {
//        $lot = Lot::findOrFail($id);
//
//        if (Auth::id() === $lot->user_id) {
//            $lot->delete();
//
//            return redirect()->route('lots.index')->with('success_message', 'Лот успешно удалён');
//        }
    }
}

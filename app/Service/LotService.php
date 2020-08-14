<?php


namespace App\Service;


use App\Jobs\ProcessLotCancel;
use App\Lot;
use App\Offer;
use Illuminate\Support\Facades\Auth;

class LotService
{
    const ADD_LOT = 'addToAuction';
    const REMOVE_LOT = 'removeFromAuction';
    const UPDATE_LOT = 'update';

    private $imageService;
    private $dateService;

    public function __construct(ImageService $imageService, DateService $dateService)
    {
        $this->dateService = $dateService;
        $this->imageService = $imageService;
    }


    /**
     * @param $lot
     */
    public function mainSwitch($lot)//Как избавиться от этой конструкции :((
    {
        if ($lot->status && request()->action == self::REMOVE_LOT) {//Мб вынести условия в отделюную функцию...
            $this->removeLotFromAuction($lot);
        } elseif (!$lot->status && request()->action === self::ADD_LOT) {
            $this->addLotToAuction($lot);
        } elseif (request()->action === self::UPDATE_LOT) {
            $this->update($lot);
        }

    }

    /**
     * @param $lot
     */
    private function removeLotFromAuction($lot)//Нужно дописать вычисление ставки итоговой
    {
        $lot->status = 0;//Возможно есть способ удалить из очереди... Есть вариант сохранять в бд uuid
        Offer::where('lot_id', $lot->id)->firstOrFail()->delete();
        session()->flash('success_message', 'Лот успешно снят с аукционна!');
        $lot->update();
    }

    /**
     * @param $lot
     */
    private function addLotToAuction($lot)
    {
        $deferenceHours = $this->dateService->getDeferenceHours($lot->timeLeft);

        $lot->status = 1;
        $offer = new Offer([
            'lot_id' => $lot->id,
            'bet_on_lot' => $lot->startingPrice,
        ]);

        ProcessLotCancel::dispatch($lot, $offer)->delay($deferenceHours);//Только это придумал :D Можно ли так...

        $lot->offer()->save($offer);
        $lot->update();
        session()->flash('success_message', 'Лот успешно выставлен!');

    }

    private function update($lot)
    {

        $path = $this->imageService->handleUploadedImage(request()->file('lot.image'));
        $lot->update([
            'name' => request()->lot['nameLot'],
            'description' => request()->lot['description'],
            'startingPrice' => request()->lot['startingPrice'],
            'timeLeft' => request()->lot['timeLeft'],
            'pathImage' => $path,
            'user_id' => Auth::id(),
        ]);
        session()->flash('success_message', 'Лот успешно обновлён!');

    }
     public function store($request){
         $path = $this->imageService->handleUploadedImage($request->file('lot.image'));

         Lot::create([
             'name' => $request->lot['nameLot'],
             'description' => $request->lot['description'],
             'startingPrice' => $request->lot['startingPrice'],
             'timeLeft' => $request->lot['timeLeft'],
             'pathImage' => $path,
             'user_id' => Auth::id(),
         ]);
     }

}

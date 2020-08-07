<?php


namespace App\Service;


use App\Jobs\ProcessLotCancel;
use App\Offer;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class LotService
{
    const ADD_LOT = 'addToAuction';
    const REMOVE_LOT = 'removeFromAuction';
    const UPDATE_LOT = 'update';

    private $imageService;

    public function __construct(ImageService $imageService)
    {
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
        $date = Carbon::create($lot->timeLeft);
        $deferenceHours = $date->diffInHours(now());
        $lot->status = 1;

        ProcessLotCancel::dispatch($lot)->delay($deferenceHours);//Только это придумал :D
        $offer = new Offer([
            'lot_id' => $lot->id,
            'bet_on_lot' => $lot->startingPrice,
        ]);

        $lot->offer()->save($offer);
        session()->flash('success_message', 'Лот успешно выставлен!');
        $lot->update();
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

}

<?php


namespace App\Service;


use App\Jobs\ProcessLotCancel;
use App\Offer;
use Carbon\Carbon;

class LotService
{


    public function handleUploadedImage($image): string
    {
        if (!is_null($image)) {
            $path = $image->store('uploads', 'public');
        } else {
            $path = config('constants.PATH_DEFAULT_IMAGE');//Как-то это поправить надо...
        }
        return $path;
    }

    public function addOrRemoveToAuction($lot)
    {
        if ($lot->status && request()->has('lotRemove')) {//Мб вынести условия в отделюную функцию...
            $this->removeLotFromAuction($lot);

        } elseif (!$lot->status && request()->has('lotAdd')) {
            $this->addLotToAuction($lot);
        }
    }

    private function removeLotFromAuction($lot)//Нужно дописать вычисление ставки итоговой
    {
        $lot->status = 0;//Возможно есть способ удалить из очереди... Есть вариант сохранять в бд uuid
        Offer::where('lot_id', $lot->id)->firstOrFail()->delete();
        session()->flash('success_message', 'Лот успешно снят с аукционна!');
        $lot->update();
    }

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


}

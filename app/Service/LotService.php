<?php


namespace App\Service;


use App\Jobs\ProcessLotCancel;
use App\Lot;

class LotService
{
    public function handleUploadedImage($image): string
    {
        if (!is_null($image)) {
            $path = $image->store('uploads', 'public');
        } else {
            $path = '/uploads/no.jpg';//Как-то это поправить надо...
        }
        return $path;
    }

    public function addOrRemoveToAuction(int $id)
    {

        $lot = Lot::findOrFail($id);
        if ($lot->status && request()->has('lotRemove')) {//Мб вынести условия в отделюную функцию...
            $this->removeLotFromAuction($lot);

        } elseif (!$lot->status && request()->has('lotAdd')) {
            $this->addLotToAuction($lot);
        }

    }

    private function removeLotFromAuction($lot)//Нужно дописать вычисление ставки итоговой
    {
        $lot->status = 0;//Возможно есть способ удалить из очереди... Есть вариант сохранять в бд uuid
        session()->flash('success_message', 'Лот успешно снят с аукционна!');
        $lot->update();
    }

    private function addLotToAuction($lot)
    {
        $lot->status = 1;
        ProcessLotCancel::dispatch($lot)->delay(now()->addHours($lot->timeLeft));//Для проверки можно заменить на addMinutes addHours
        session()->flash('success_message', 'Лот успешно выставлен!');
        $lot->update();
    }


}

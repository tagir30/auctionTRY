<?php


namespace App\Service;


use App\Events\OfferStatusChanged;
use App\Jobs\ProcessLotCancel;
use App\Lot;
use App\Offer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\MessageBag;

class LotService
{
    private $imageService;
    private $dateService;

    /**
     * LotService constructor.
     * @param ImageService $imageService
     * @param DateService $dateService
     */
    public function __construct(ImageService $imageService, DateService $dateService)
    {
        $this->dateService = $dateService;
        $this->imageService = $imageService;
    }


    /**
     * @param $lot
     * @return MessageBag
     */
//    public function mainSwitch($lot)//Как избавиться от этой конструкции :((
//    {
//        if ($lot->status && request()->action == self::REMOVE_LOT) {//Мб вынести условия в отделюную функцию...
//            $this->removeLotFromAuction($lot);
//        } elseif (!$lot->status && request()->action === self::ADD_LOT) {
//            $this->addLotToAuction($lot);
//        } elseif (request()->action === self::UPDATE_LOT && !$lot->status) {
//            $this->update($lot);
//        } else{
//           $errors = new MessageBag();
//           $errors->add('lotInAuction', 'Лот находиться на аукционе, изменение запрещено!');
//           return $errors;
//        }
//    }

    /**
     * @param $lot
     */
    public function removeLotFromAuction($lot)
    {
        //Нужно дописать вычисление ставки итоговой
        $lot->status = 0;//Возможно есть способ удалить из очереди... Есть вариант сохранять в бд uuid
        session()->flash('success_message', 'Лот успешно снят с аукционна!');
        $lot->update();
        event(new OfferStatusChanged($lot));

//        Offer::where('lot_id', $lot->id)->firstOrFail()->delete();//Эвент не успевает проработать...

    }

    /**
     * @param $lot
     */
    public function addLotToAuction($lot) : void
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
        event(new OfferStatusChanged($lot));
        session()->flash('success_message', 'Лот успешно выставлен!');

    }

    public function update($lot) : void
    {

        $path = $this->imageService->handleUploadedUpdateImage(request()->file('lot.image'));
        $lot->update([
            'name' => request()->lot['nameLot'],
            'description' => request()->lot['description'],
            'startingPrice' => request()->lot['startingPrice'],
            'timeLeft' => request()->lot['timeLeft'],
            'pathImage' => $path ?? $lot->pathImage,
            'user_id' => Auth::id(),
        ]);
        session()->flash('success_message', 'Лот успешно обновлён!');

    }

    public function store($request) : void
    {
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

<?php


namespace App\Service;


use App\Events\OfferStatusChanged;
use App\Jobs\ProcessLotCancel;
use App\Lot;
use App\Offer;
use Illuminate\Support\Facades\Auth;

class LotService
{
    const LOT_IN_AUCTION = 1;
    const LOT_NOT_IN_AUCTION = 0;
    const LOT_SOLD = -1;

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
     */
    public function removeLotFromAuction($lot)
    {
        //Нужно дописать вычисление ставки итоговой
        $lot->status = self::LOT_NOT_IN_AUCTION; // -1 в будещем
        $lot->update();
        event(new OfferStatusChanged($lot));
        // Возможно просто запустить job для удаления ...
        ProcessLotCancel::dispatch($lot, $lot->offer)->delay(5); //Вдруг event долго идти будет
        // Offer::where('lot_id', $lot->id)->firstOrFail()->delete();//Эвент не успевает проработать...
        session()->flash('success_message', 'Лот успешно снят с аукционна!');
    }

    /**
     * @param $lot
     */
    public function addLotToAuction($lot): void
    {
        $deferenceHours = $this->dateService->getDeferenceHours($lot->timeLeft);

        $lot->status = self::LOT_IN_AUCTION;
        $offer = new Offer([
            'lot_id' => $lot->id,
            'bet_on_lot' => $lot->startingPrice,
        ]);
        $lot->offer()->save($offer);
        $lot->update();
        ProcessLotCancel::dispatch($lot, $offer)->delay(now()->addHours($deferenceHours)); //Чем это заменить можно...


        event(new OfferStatusChanged($lot));
        session()->flash('success_message', 'Лот успешно выставлен!');
    }

    public function update($lot, $request): void
    {
        $path = $this->imageService->handleUploadedUpdateImage(request()->file('lot.image'));

        $lot->fill($request->validated()['lot']);
        $lot->user_id = Auth::id();
        $lot->pathImage = $path ?? $lot->pathImage;
        $lot->save();

        session()->flash('success_message', 'Лот успешно обновлён!');
    }

    public function store($request): void
    {

        $path = $this->imageService->handleUploadedImage($request->file('lot.image'));

        $lot = new Lot();
        $lot->fill($request->validated()['lot']);
        $lot->user_id = Auth::id();
        $lot->pathImage = $path ?? $lot->pathImage;
        $lot->save();

    }
}

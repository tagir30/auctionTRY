<?php


namespace App\Service;


use Carbon\Carbon;

class DateService
{

    public function getDeferenceHours($timeLeft)
    {
        $deferenceHours = Carbon::create($timeLeft)->diffInHours(now());
        return $deferenceHours;
    }
}

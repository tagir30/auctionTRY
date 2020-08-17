<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Auth;

class Lot extends Model
{
    protected $fillable = ['name', 'description', 'startingPrice', 'timeLeft', 'pathImage', 'user_id'];

    /**
     * @return HasOne
     */
    public function offer()
    {
        return $this->hasOne(Offer::class);
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeGetActiveLot($query){
        return $query->where('user_id', Auth::id())->where('status', 1);
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeGetCompletedLot($query){
        return $query->where('user_id', Auth::id())->where('status', -1);
    }

}

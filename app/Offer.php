<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    protected $fillable = ['lot_id', 'bet_on_lot', 'user_id_bet'];

    public function lot(){
        return $this->belongsTo(Lot::class);
    }
}

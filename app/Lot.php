<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lot extends Model
{
    protected $fillable = ['name', 'description', 'startingPrice', 'timeLeft', 'pathImage', 'user_id'];

}

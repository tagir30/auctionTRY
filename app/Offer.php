<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    protected $fillable = ['lot_id', 'user_id', 'price', 'pathImage'];
}

<?php

namespace eTorn\Models;

use Illuminate\Database\Eloquent\Model;


class TiketItem extends Model
{
    protected $table = 'TIKET_ITEM';

    public $timestamps = true;
    
    protected $fillable = [
        'id', 'name','id_tiket','price_producto','id_producto', 'active','quantity'
    ];

}

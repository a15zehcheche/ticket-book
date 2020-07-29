<?php

namespace eTorn\Models;

use Illuminate\Database\Eloquent\Model;


class ProductoTipos extends Model
{
    protected $table = 'PRODUCTO_TIPOS';

    public $timestamps = true;

    protected $fillable = [
        'id', 'name','detall','active'
    ];

}
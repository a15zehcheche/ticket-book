<?php

namespace eTorn\Models;

use Illuminate\Database\Eloquent\Model;


class Espacio extends Model
{
    protected $table = 'ESPACIO';

    public $timestamps = true;
    
    protected $fillable = [
        'id', 'name','active'
    ];

}
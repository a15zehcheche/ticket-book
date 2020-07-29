<?php

namespace eTorn\Models;

use Illuminate\Database\Eloquent\Model;


class Producto extends Model
{
    protected $table = 'PRODUCTO';

    public $timestamps = true;
    
    protected $fillable = [
        'id', 'name','detall','price','photo_path', 'active','id_tipos'
    ];

}
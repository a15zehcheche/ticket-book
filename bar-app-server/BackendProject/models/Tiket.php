<?php

namespace eTorn\Models;

use Illuminate\Database\Eloquent\Model;


class Tiket extends Model
{
    protected $table = 'TIKET';

    public $timestamps = true;
    
    protected $fillable = [
        'id', 'name','id_ESPACIO','name_ESPACIO','id_producto', 'active','price_to_pay','pay_at'
    ];

    
    /**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function items()
    {
        return $this->hasMany('eTorn\Models\TiketItem', 'id_tiket');
    }


} 

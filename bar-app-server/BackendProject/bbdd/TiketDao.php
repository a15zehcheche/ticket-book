<?php

namespace eTorn\Bbdd;

use eTorn\Models\Tiket;

class TiketDao
{    
    public function findAll() {
        $tikets = Tiket::all();
        for ($i = 0; $i < count($tikets); ++$i) {
            $tikets[$i]->{"items"} =  $tikets[$i]->items;
         }
        return $tikets;
    }

    public function findById($id) {
        return Tiket::where('id', $id)->first();
    }

    public function findByProperty($property, $value) {
        return Tiket::where($property, $value)->get();
    }

    public function save(Tiket $store) {
        return $store->save();
    }

    public function delete(Tiket $store)
    {
        return $store->delete();
    }

    public function itemsFindById($id) {
        return Tiket::where('id', $id)->items();
    }
}
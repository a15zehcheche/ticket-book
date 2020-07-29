<?php

namespace eTorn\Bbdd;

use eTorn\Models\Espacio;

class EspacioDao
{
    public function findAll() {
        return Espacio::all();
    }

    public function findById($id) {
        return Espacio::where('id', $id)->first();
    }

    public function findByProperty($property, $value) {
        return Espacio::where($property, $value)->get();
    }

    public function save(Espacio $store) {
        return $store->save();
    }

    public function delete(Espacio $store)
    {
        return $store->delete();
    }
}
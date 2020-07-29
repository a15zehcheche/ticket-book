<?php

namespace eTorn\Bbdd;

use eTorn\Models\Producto;

class ProductoDao
{
    public function findAll() {
        return Producto::all();
    }

    public function findById($id) {
        return Producto::where('id', $id)->first();
    }

    public function findByProperty($property, $value) {
        return Producto::where($property, $value)->get();
    }

    public function save(Producto $store) {
        return $store->save();
    }

    public function delete(Producto $store)
    {
        return $store->delete();
    }
}
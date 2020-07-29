<?php

namespace eTorn\Bbdd;

use eTorn\Models\ProductoTipos;

class ProductoTiposDao
{
    public function findAll() {
        return ProductoTipos::all();
    }

    public function findById($id) {
        return ProductoTipos::where('id', $id)->first();
    }

    public function findByProperty($property, $value) {
        return ProductoTipos::where($property, $value)->get();
    }

    public function save(ProductoTipos $store) {
        return $store->save();
    }

    public function delete(ProductoTipos $store)
    {
        return $store->delete();
    }
}
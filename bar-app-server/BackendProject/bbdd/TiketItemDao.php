<?php

namespace eTorn\Bbdd;

use eTorn\Models\TiketItem;

class TiketItemDao
{
    public function findAll() {
        return TiketItem::all();
    }

    public function findById($id) {
        return TiketItem::where('id', $id)->first();
    }

    public function findByProperty($property, $value) {
        return TiketItem::where($property, $value)->get();
    }

    public function save(TiketItem $item) {
        return $item->save();
    }

    public function delete(TiketItem $item)
    {
        return $item->delete();
    }
}
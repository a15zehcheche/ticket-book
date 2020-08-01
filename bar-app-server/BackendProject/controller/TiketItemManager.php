<?php

namespace eTorn\Controller;

use eTorn\Bbdd\TiketItemDao;
use eTorn\Models\TiketItem;
use eTorn\Models\Queue;
use eTorn\Constants\ConstantsPaths;

class TiketItemManager {

    private $tiketItemDao;

    function __construct() {
        $this->tiketItemDao = new TiketItemDao();
    }

    public function findAll() {
        return $this->tiketItemDao->findAll();
    }

    public function findById($id) {
        $tiketItem = $this->tiketItemDao->findById($id);

        if (!$tiketItem) {
            return [
                'err' => 'tiketItem not found'
            ];
        }

        return $tiketItem;
    }

    public function delete($id) {
        $tiketItem = $this->tiketItemDao->findById($id);

        if (!$tiketItem) {
            return [
                'done' => false
            ];
        }

        return array("done" => $this->tiketItemDao->delete($tiketItem));
    }

    public function save($body) {

        $tiketItem = new TiketItem();
       

        try{
            $tiketItem->id_tiket = $body->tiket->id;
            $tiketItem->id_producto = $body->item->id;
            $tiketItem->name = $body->item->name;
            $tiketItem->price_producto = floatval($body->item->price);
            $tiketItem->quantity = $body->quantity;
            //return["data"=>$tiketItem];
            $tiketItem->save();

            return [
                'done' => true,
                'data' => $tiketItem
            ];

        } catch (\Exception $e) {
            Logger::getInstance()->logError('tiketItemManager@save - ' . $e->getMessage());
            return array('done' => false);
        }
    }

    public function update($body, $id)
    {
        try {

            $tiketItem = TiketItem::find($id);

            if (!$tiketItem) {
                return [
                    'done' => false
                ];
            }

            if (!array_key_exists('name', (array) $body)) {
                return [
                    'done' => false
                ];
            }

            $tiketItem->name = $body->name;

            return [
                'done' => $this->tiketItemDao->save($tiketItem),
                'tiketItem' => $tiketItem
            ];

        } catch (\Exception $e) {
            Logger::error('tiketItemManager@update - ' . $e->getMessage());
            return array('done' => false);
        }
    }
    
   
}

<?php

namespace eTorn\Controller;

use eTorn\Bbdd\ProductoTiposDao;
use eTorn\Models\ProductoTipos;
use eTorn\Models\Queue;
use eTorn\Constants\ConstantsPaths;

class ProductoTiposManager {

    private $productoTiposDao;

    function __construct() {
        $this->productoTiposDao = new ProductoTiposDao();
    }

    public function findAll() {
        return $this->productoTiposDao->findAll();
    }

    public function findById($id) {
        $type = $this->productoTiposDao->findById($id);

        if (!$type) {
            return [
                'err' => 'producto not found'
            ];
        }

        return $type;
    }

    public function delete($id) {
        $type = $this->productoTiposDao->findById($id);

        if (!$type) {
            return [
                'done' => false
            ];
        }

        return array("done" => $this->productoTiposDao->delete($type));
    }

    public function save($body) {

        $type = new ProductoTipos();
        $type->name = $body->name;

        try{
      
            $type->save();

            return [
                'done' => true
            ];

        } catch (\Exception $e) {
            Logger::getInstance()->logError('ProductoTiposManager@save - ' . $e->getMessage());
            return array('done' => false);
        }
    }

    public function update($body, $id)
    {
        try {

            $type = ProductoTipos::find($id);

            if (!$type) {
                return [
                    'done' => false
                ];
            }

            if (!array_key_exists('name', (array) $body)) {
                return [
                    'done' => false
                ];
            }

            $type->name = $body->name;

            return [
                'done' => $this->productoTiposDao->save($type),
                'producto' => $type
            ];

        } catch (\Exception $e) {
            Logger::error('ProductoTiposManager@update - ' . $e->getMessage());
            return array('done' => false);
        }
    }
}

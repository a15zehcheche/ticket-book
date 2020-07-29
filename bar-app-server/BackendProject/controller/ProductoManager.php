<?php

namespace eTorn\Controller;

use eTorn\Bbdd\ProductoDao;
use eTorn\Models\Producto;
use eTorn\Models\Queue;
use eTorn\Constants\ConstantsPaths;

class productoManager {

    private $productoDao;

    function __construct() {
        $this->productoDao = new ProductoDao();
    }

    public function findAll() {
        return $this->productoDao->findAll();
    }

    public function findById($id) {
        $producto = $this->productoDao->findById($id);

        if (!$producto) {
            return [
                'err' => 'producto not found'
            ];
        }

        return $producto;
    }

    public function delete($id) {
        $producto = $this->productoDao->findById($id);

        if (!$producto) {
            return [
                'done' => false
            ];
        }

        return array("done" => $this->productoDao->delete($producto));
    }

    public function saveSimple($body) {

        $producto = new Producto();
        try{
			$producto->name = $body->name;
			$producto->detall = $body->detall;
            $producto->price = floatval($body->price);
            $producto->id_tipos = $body->id_tipos;
         
            //$imagePath = ImageAlmacenator::getInstance()->saveImage($imageFile);
            //$producto->photo_path = $imagePath;
            
            $producto->save();

            return [
                'done' => true
            ];

        } catch (\Exception $e) {
            Logger::getInstance()->logError('productoManager@save - ' . $e->getMessage());
            return array('done' => false);
        }
    }

    
    public function save($body, $imageFile) {

        $producto = new Producto();
        try{
			$producto->name = $body->name;
			$producto->detall = $body->detall;
            $producto->price = $body->price;
            $producto->id_tipos = $body->id_tipos;
         
            //$imagePath = ImageAlmacenator::getInstance()->saveImage($imageFile);
            //$producto->photo_path = $imagePath;
            
            $producto->save();

            return [
                'done' => true
            ];

        } catch (\Exception $e) {
            Logger::getInstance()->logError('productoManager@save - ' . $e->getMessage());
            return array('done' => false);
        }
    }

    public function update($body, $id)
    {
        try {

            $producto = producto::find($id);

            if (!$producto) {
                return [
                    'done' => false
                ];
            }

            if (array_key_exists('name', (array) $body)) {
                $producto->name = $body->name;
            }

            if (array_key_exists('id_tipos', (array) $body)) {
                $producto->id_tipos = $body->id_tipos;
            }

            if (array_key_exists('price', (array) $body)) {
                $producto->price = $body->price;
            }


            return [
                'done' => $this->productoDao->save($producto),
                'producto' => $producto
            ];

        } catch (\Exception $e) {
            Logger::error('productoManager@update - ' . $e->getMessage());
            return array('done' => false);
        }
    }
}

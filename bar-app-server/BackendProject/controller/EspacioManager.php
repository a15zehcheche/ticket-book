<?php

namespace eTorn\Controller;

use eTorn\Bbdd\EspacioDao;
use eTorn\Models\Espacio;
use eTorn\Constants\ConstantsPaths;

class EspacioManager {

    private $espacioDao;

    function __construct() {
        $this->espacioDao = new EspacioDao();
    }

    public function findAll() {
        return $this->espacioDao->findAll();
    }

    public function findById($id) {
        $espacio = $this->espacioDao->findById($id);

        if (!$espacio) {
            return [
                'err' => 'espacio not found'
            ];
        }

        return $espacio;
    }

    public function delete($id) {
        $espacio = $this->espacioDao->findById($id);

        if (!$espacio) {
            return [
                'done' => false
            ];
        }

        return array("done" => $this->espacioDao->delete($espacio));
    }

    public function save($name, $imageFile) {

        $espacio = new Espacio();
        $espacio->name = $name;

        try{
            $imagePath = ImageAlmacenator::getInstance()->saveImage($imageFile);
            $espacio->photo_path = $imagePath;
            
            $espacio->save();

            $bucketQueue = new Queue();
            $bucketQueue->type = 'BUCKETS';

            $espacio->queues()->save($bucketQueue);

            return [
                'done' => true
            ];

        } catch (\Exception $e) {
            Logger::getInstance()->logError('espacioManager@save - ' . $e->getMessage());
            return array('done' => false);
        }
    }

    public function update($body, $id)
    {
        try {

            $espacio = Espacio::find($id);

            if (!$espacio) {
                return [
                    'done' => false
                ];
            }

            if (!array_key_exists('name', (array) $body)) {
                return [
                    'done' => false
                ];
            }

            $espacio->name = $body->name;

            return [
                'done' => $this->espacioDao->save($espacio),
                'espacio' => $espacio
            ];

        } catch (\Exception $e) {
            Logger::error('espacioManager@update - ' . $e->getMessage());
            return array('done' => false);
        }
    }
}

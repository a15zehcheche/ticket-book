<?php

namespace eTorn\Controller;

use eTorn\Bbdd\TiketDao;
use eTorn\Models\Tiket;
use eTorn\Models\Queue;
use eTorn\Constants\ConstantsPaths;

class TiketManager {

    private $tiketDao;

    function __construct() {
        $this->tiketDao = new TiketDao();
    }

    public function findAll() {
        return $this->tiketDao->findAll();
    }

    public function findById($id) {
        $tiket = $this->tiketDao->findById($id);

        if (!$tiket) {
            return [
                'err' => 'tiket not found'
            ];
        }

        return $tiket;
    }

    public function delete($id) {
        $tiket = $this->tiketDao->findById($id);

        if (!$tiket) {
            return [
                'done' => false
            ];
        }

        return array("done" => $this->tiketDao->delete($tiket));
    }

    public function save($body) {

        $tiket = new Tiket();
        $tiket->id_ESPACIO = $body->id_ESPACIO;
        $tiket->name_ESPACIO = $body->name_ESPACIO;
        $tiket->name = $body->name;

        try{
        
            $tiket->save();

            return [
                'done' => true
            ];

        } catch (\Exception $e) {
            Logger::getInstance()->logError('tiketManager@save - ' . $e->getMessage());
            return array('done' => false);
        }
    }

    public function update($body, $id)
    {
        try {

            $tiket = Tiket::find($id);

            if (!$tiket) {
                return [
                    'done' => false
                ];
            }

            if (!array_key_exists('name', (array) $body)) {
                return [
                    'done' => false
                ];
            }

            $tiket->name = $body->name;

            return [
                'done' => $this->tiketDao->save($tiket),
                'tiket' => $tiket
            ];

        } catch (\Exception $e) {
            Logger::error('tiketManager@update - ' . $e->getMessage());
            return array('done' => false);
        }
    }
    public function disableTiket($body, $id)
    {
        try {

            $tiket = Tiket::find($id);

            if (!$tiket) {
                return [
                    'done' => false
                ];
            }

         
            $tiket->active = 0;

            return [
                'done' => $this->tiketDao->save($tiket),
                'tiket' => $tiket
            ];

        } catch (\Exception $e) {
            Logger::error('tiketManager@update - ' . $e->getMessage());
            return array('done' => false);
        }
    }

}

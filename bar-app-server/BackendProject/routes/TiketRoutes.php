<?php

namespace eTorn\Routes;

use eTorn\Controller\TiketManager;
use Phroute\Phroute\RouteCollector;

class TiketRoutes
{
    public static function manageRoutes(RouteCollector $router)
    {
        $prefix = '';

        // -----------------------------------------------------------------
        // ---------------------------- TiketS -----------------------------
        // -----------------------------------------------------------------

        $router->get($prefix . '/tikets', function () {
            return (new TiketManager())->findAll();
        });

        $router->get($prefix . '/tiket/{id}', function ($id) {
            return (new TiketManager())->findById($id);
        });

        $router->post($prefix . '/tiket', function () {
            $body = file_get_contents('php://input');
            return (new TiketManager())->save(json_decode($body));
        });

        $router->put($prefix . '/disableTiket/{id}', function ($id) {
            $body = file_get_contents('php://input');
            return (new TiketManager())->disableTiket(json_decode($body), $id);
        });

        $router->put($prefix . '/tiket/{id}', function ($id) {
            $body = file_get_contents('php://input');
            return (new TiketManager())->update(json_decode($body), $id);
        });

        $router->delete($prefix . '/tiket/{id}', function ($id) {
            return (new TiketManager())->delete($id);
        });

        
        $router->get($prefix . '/tiketitemsbyid/{id}', function ($id) {
            return (new TiketManager())->findById($id)->items;
        });

    }
}
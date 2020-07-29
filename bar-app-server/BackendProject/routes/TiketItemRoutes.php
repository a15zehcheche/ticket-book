<?php

namespace eTorn\Routes;

use eTorn\Controller\TiketItemManager;
use Phroute\Phroute\RouteCollector;

class TiketItemRoutes
{
    public static function manageRoutes(RouteCollector $router)
    {
        $prefix = '';

        // -----------------------------------------------------------------
        // ---------------------------- TiketItemS -----------------------------
        // -----------------------------------------------------------------

        $router->get($prefix . '/tiketitems', function () {
            return (new TiketItemManager())->findAll();
        });

        $router->get($prefix . '/tiketitem/{id}', function ($id) {
            return (new TiketItemManager())->findById($id);
        });

        $router->post($prefix . '/tiketitem', function () {
            // Form data for file upload too
            $body = file_get_contents('php://input');
            return (new TiketItemManager())->save(json_decode($body) );
        });

        $router->put($prefix . '/tiketitem/{id}', function ($id) {
            $body = file_get_contents('php://input');
            return (new TiketItemManager())->update(json_decode($body), $id);
        });

        $router->delete($prefix . '/tiketitem/{id}', function ($id) {
            return (new TiketItemManager())->delete($id);
        });

    }
}
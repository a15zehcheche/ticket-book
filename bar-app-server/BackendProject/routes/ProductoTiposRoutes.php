<?php

namespace eTorn\Routes;

use eTorn\Controller\ProductoTiposManager;
use Phroute\Phroute\RouteCollector;

class ProductoTiposRoutes
{
    public static function manageRoutes(RouteCollector $router)
    {
        $prefix = '';

        // -----------------------------------------------------------------
        // ---------------------------- productoS -----------------------------
        // -----------------------------------------------------------------

        $router->get($prefix . '/productostipos', function () {
            return (new ProductoTiposManager())->findAll();
        });

        $router->get($prefix . '/productotipos/{id}', function ($id) {
            return (new ProductoTiposManager())->findById($id);
        });

        $router->post($prefix . '/productotipos', function () {
            // Form data for file upload too
            $body = file_get_contents('php://input');
            return (new ProductoTiposManager())->save(json_decode($body));

        });

        $router->put($prefix . '/productotipos/{id}', function ($id) {
            $body = file_get_contents('php://input');
            return (new ProductoTiposManager())->update(json_decode($body), $id);
        });

        $router->delete($prefix . '/productotipos/{id}', function ($id) {
            return (new ProductoTiposManager())->delete($id);
        });

    }
}
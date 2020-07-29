<?php

namespace eTorn\Routes;

use eTorn\Controller\ProductoManager;
use Phroute\Phroute\RouteCollector;

class ProductoRoutes
{
    public static function manageRoutes(RouteCollector $router)
    {
        $prefix = '';

        // -----------------------------------------------------------------
        // ---------------------------- productoS -----------------------------
        // -----------------------------------------------------------------

        $router->get($prefix . '/productos', function () {
            return (new ProductoManager())->findAll();
        });

        $router->get($prefix . '/producto/{id}', function ($id) {
            return (new ProductoManager())->findById($id);
        });

        $router->post($prefix . '/producto', function () {
            // Form data for file upload too
            $body = file_get_contents('php://input');
            //return json_decode($body);
            //return (new ProductoManager())->save(json_decode($body), $_FILES['photoproducto']);
            return (new ProductoManager())->saveSimple(json_decode($body));

        });

        $router->put($prefix . '/producto/{id}', function ($id) {
            $body = file_get_contents('php://input');
            return (new ProductoManager())->update(json_decode($body), $id);
        });

        $router->delete($prefix . '/producto/{id}', function ($id) {
            return (new ProductoManager())->delete($id);
        });

    }
}
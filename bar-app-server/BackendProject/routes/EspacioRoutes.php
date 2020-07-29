<?php

namespace eTorn\Routes;

use eTorn\Controller\EspacioManager;
use Phroute\Phroute\RouteCollector;

class EspacioRoutes
{
    public static function manageRoutes(RouteCollector $router)
    {
        $prefix = '';

        // -----------------------------------------------------------------
        // ---------------------------- EspacioS -----------------------------
        // -----------------------------------------------------------------

        $router->get($prefix . '/espacios', function () {
            return (new EspacioManager())->findAll();
        });

        $router->get($prefix . '/espacio/{id}', function ($id) {
            return (new EspacioManager())->findById($id);
        });

        $router->post($prefix . '/espacio', function () {
            // Form data for file upload too
            return (new EspacioManager())->save($_POST['name'], $_FILES['photoEspacio']);
        });

        $router->put($prefix . '/espacio/{id}', function ($id) {
            $body = file_get_contents('php://input');
            return (new EspacioManager())->update(json_decode($body), $id);
        });

        $router->delete($prefix . '/espacio/{id}', function ($id) {
            return (new EspacioManager())->delete($id);
        });

    }
}
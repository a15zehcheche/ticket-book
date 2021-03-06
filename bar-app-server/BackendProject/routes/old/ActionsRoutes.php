<?php

namespace eTorn\Routes;

use eTorn\Controller\BucketManager;
use eTorn\Controller\TurnManager;
use eTorn\Models\Config;
use eTorn\Models\Turn;
use Phroute\Phroute\RouteCollector;

class ActionsRoutes
{
    public static function manageRoutes(RouteCollector $router)
    {
        $prefix = '';

        // -----------------------------------------------------------------
        // ---------------------------- ACTIONS ----------------------------
        // -----------------------------------------------------------------

        $router->get($prefix . '/store/{idStore}/nextTurn', function ($idStore) {

            if (isset($_REQUEST['till'])) {
                $idTill = $_REQUEST['till'];
            } else {
                $idTill = null;
            }

            return (new TurnManager())->nextTurn($idStore, $idTill);
        });

        $router->get($prefix . '/store/{idStore}/actualTurn', function ($idStore) {
            return (new TurnManager())->getActualTurns($idStore);
        });

        $router->get($prefix . '/store/{idStore}/waitingTurns', function ($idStore) {
            return (new TurnManager())->waitingTurns($idStore);
        });

        $router->post($prefix . '/store/{idStore}/turn', function ($idStore) {
            $body = file_get_contents('php://input');
			$body = json_decode($body);
            return (new TurnManager())->newNormalTurn($body, $idStore);
        });

        $router->post($prefix . '/store/{idStore}/vipTurn', function ($idStore) {
            $body = file_get_contents('php://input');
            $body = json_decode($body);
            return (new TurnManager())->newVipTurn($body, $idStore);
        });

        $router->post($prefix . '/store/{idStore}/hourTurn', function ($idStore) {
            $body = file_get_contents('php://input');
            $body = json_decode($body);
            return (new TurnManager())->newHourTurn($body, $idStore); // timestamp!!!
        });

        $router->post($prefix . '/clockUpdate', function () {
            //$minuteInterval = (int) Config::where('key', 'MIN_DURATION_BUCKETS')->first()->value;
			return (new TurnManager())->updateHourTurns();
            //return array('done' => false);
        });

		$router->get($prefix . '/store/{id}/bucketsNextHour', function ($id) {
			return (new BucketManager())->findNextBuckets($id);
		});

		$router->get($prefix . '/store/{idStore}/allTurns', function ($idStore) {
            return (new TurnManager())->allStoreTurns($idStore);
        });

		$router->post($prefix . '/tokenTurns', function () {
			$body = file_get_contents('php://input');
			$body = json_decode($body);

			if (!isset($body->token)) {
				return [];
			}

			return (new TurnManager())->turnsOfThisToken($body->token);
		});
    }
}
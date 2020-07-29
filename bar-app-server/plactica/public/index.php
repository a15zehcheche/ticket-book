<?php  
require '../vendor/autoload.php';  
require '../src/models/dev.php';  
require '../src/handlers/exceptions.php';

$config = include('../src/config.php');

$app = new SlimApp(['settings'=> $config]);

$container = $app->getContainer();

$capsule = new IlluminateDatabaseCapsuleManager;
$capsule->addConnection($container['settings']['db']);
$capsule->setAsGlobal();
$capsule->bootEloquent();

$capsule->getContainer()->singleton(
  IlluminateContractsDebugExceptionHandler::class,
  AppExceptionsHandler::class
);


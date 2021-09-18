<?php

use \DI\Container;
use Slim\Factory\AppFactory;

require __DIR__ . '/../../vendor/autoload.php';


//Crea el contenedor usando PHP-DI.
$container = new Container();

//Agrega el contenedor para crear la aplicación en AppFactory.
AppFactory::setContainer($container);
$app = AppFactory::create();
$container = $app->getContainer();

//Define la ruta base.
$app->setBasePath('/stack/backend');

//Agrega Middleware de enrutamiento.
$app->addRoutingMiddleware();

//Se define la zona horaria para obtener la fecha y hora correcta. 
date_default_timezone_set('America/Santiago');


require __DIR__ . "/Configs.php";
require __DIR__ . "/Dependencies.php";
require __DIR__ . "/Loggers.php";
require __DIR__ . "/Middlewares.php";
require __DIR__ . "/Routes.php";
require __DIR__ . "/Models.php";


//Agrega el Middleware de cierre.
$app->add($beforeMiddleware);

//Agrega el Middleware de error con Logger, genera un archivo log.
$logger = $container->get('logger_files');
$errorMiddleware = $app->addErrorMiddleware(true, true, true, $logger);

//Se inicia la aplicación.
$app->run();
<?php

use App\Application;
use App\Controller;
use App\Router;

error_reporting(E_ALL);
ini_set('display_errors', true);

require_once $_SERVER['DOCUMENT_ROOT'] . '/bootstrap.php';

$router = new Router();

$router->get(
    '/',
    Controller::class . '@index'
);

$router->get(
    '/about',
    Controller::class . '@about'
);

$application = new Application($router);

$application->run();

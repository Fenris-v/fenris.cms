<?php

use App\Application;
use App\Controller;
use App\Router;

error_reporting(E_ALL);
ini_set('display_errors', true);

require_once $_SERVER['DOCUMENT_ROOT'] . '/bootstrap.php';

$router = new Router();

//$router->get(
//    '/',
//    function () {
//        return 'home';
//    }
//);
//
//$router->get(
//    '/about',
//    function () {
//        return 'about';
//    }
//);

/**
 * Здесь заменил символ @ на ::
 * не нашел в интернете как вызывать метод из строки, которая была в исходном варианте
 * Думал сделать замену @ реплейсом, но решил, что это будет лишним
 */
$router->get(
    '/',
    Controller::class . '::index'
);

$router->get(
    '/about',
    Controller::class . '::about'
);

$application = new Application($router);

$application->run();

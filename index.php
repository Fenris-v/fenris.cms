<?php

use App\Application;
use App\Controller;
use App\Router;

error_reporting(E_ALL);
ini_set('display_errors', true);

/** Подключаем скрипт, который будет подключать другие файлы */
require_once $_SERVER['DOCUMENT_ROOT'] . '/bootstrap.php';

/** Создаем экземпляр роутера */
$router = new Router();

/** Создаем класс контроллера */
$controller = new Controller();

// TODO: delete not using urls
/** Регистрируем в созданном роутере доступные пути */
$router->get('/about', $controller->about());
$router->get('/news', $controller->news());
$router->get('/news/*/news/*', $controller->newsParams());
$router->post('/news', $controller->news());
$router->get('/books', $controller->books());

// FOR RELEASE
$router->get('/', $controller->index());
$router->get('/post/*', $controller->post());
$router->get('/auth', $controller->auth());
$router->get('/registration', $controller->reg());
$router->get('/profile/*', $controller->profile());

/** Создаем экземпляр для запуска приложения */
$application = new Application($router);

/** Запускаем приложение */
$application->run();


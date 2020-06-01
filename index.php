<?php

use App\Application;
use App\Controller;
use App\Router;
use App\View;

error_reporting(E_ALL);
ini_set('display_errors', true);

// Подключаем скрипт, который будет подключать другие файлы
require_once $_SERVER['DOCUMENT_ROOT'] . '/bootstrap.php';

// Создаем экземпляр роутера
$router = new Router();

// Регистрируем в созданном роутере доступные пути
$router->get(
    '/',
    function () {
        return new View\View('index', ['title' => 'Index Page']);
    }
);

$router->get(
    '/about',
    function () {
        return new View\View('about.about', ['title' => 'About Page']);
    }
);

// Создаем экземпляр для запуска приложения
$application = new Application($router);

// Запускаем приложение
$application->run();

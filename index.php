<?php

use App\Application;
use App\Controller;
use App\Model\User;
use App\Router;
use App\Session;

error_reporting(E_ALL);
ini_set('display_errors', true);

/** Подключаем скрипт, который будет подключать другие файлы */
require_once $_SERVER['DOCUMENT_ROOT'] . '/bootstrap.php';

/** Создаем пользователя и авторизовываем его, если есть токен */
$user = new User();

/** Создаем экземпляр сессии и запускаем ее */
$session = new Session();
$session->start();

if (isset($_GET['logout'])) {
    $session->destroy();

    $_COOKIE['password_token'] = null;
    setcookie('password_token', null, time() - 3600, '/');

    if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER']) {
        redirectOnPage($_SERVER['HTTP_REFERER']);
    }

    redirectOnPage();
}

if (isset($_COOKIE['password_token'])) {
    setcookie('password_token', $_COOKIE['password_token'], time() + (30 * 24 * 60 * 60), '/');
}

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
$router->get('/auth/*', $controller->auth());
$router->get('/registration', $controller->reg());
$router->get('/profile/*', $controller->profile());

/** Создаем экземпляр для запуска приложения */
$application = new Application($router);

/** Авторизуем пользователя, если есть токен */
if (!isset($_SESSION['login']) && isset($_COOKIE['password_token']) && !empty($_COOKIE['password_token'])) {
    $user->fastAuth();
}

/** Запускаем приложение */
$application->run();


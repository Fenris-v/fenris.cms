<?php

use App\Application;
use App\Controller;
use App\Model\Permission;
use App\Model\User;
use App\Router;
use App\Session;

error_reporting(E_ALL);
ini_set('display_errors', true);

/** Подключаем скрипт, который будет подключать другие файлы */
require_once $_SERVER['DOCUMENT_ROOT'] . '/bootstrap.php';

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
$router->get('/post/*', $controller->post());

// FOR RELEASE
$router->get('/', $controller->index());
//TODO: delete 'post'
$router->get('/admin/*', $controller->admin());
$router->get('/admin/*/*', $controller->admin());
$router->get('/auth', $controller->auth());
$router->get('/auth/*', $controller->auth());
$router->get('/registration', $controller->reg());
$router->get('/profile/*', $controller->profile());
$router->get('/*', $controller->categories());
$router->get('/*/*', $controller->article());

/** Создаем экземпляр для запуска приложения */
$application = new Application($router);

/** Авторизуем пользователя, если есть токен */
if (!isset($_SESSION['login']) && isset($_COOKIE['password_token']) && !empty($_COOKIE['password_token'])) {
    User::getInstance()->fastAuth();
}

if (trim(trim($_SERVER['REQUEST_URI']), '/') === 'admin') {
    if (isset($_SESSION['login']) && (User::getInstance()->isManager() || User::getInstance()->isSuperUser())) {
        redirectOnPage('/admin/articles');
    } elseif (!isset($_SESSION['login'])) {
        redirectOnPage('/auth');
    } else {
        if (isset($_SERVER['HTTP_REFERER'])) {
            redirectOnPage($_SERVER['HTTP_REFERER']);
        }

        redirectOnPage();
    }
}

/** Определяем роль пользователя */
if (isset($_SESSION['login'])) {
    $session->set('role', (new User)->getRoleId());
}

/** Запускаем приложение */
$application->run();

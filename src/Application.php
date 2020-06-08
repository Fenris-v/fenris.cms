<?php

namespace App;

use Exception;
use Illuminate\Database\Capsule\Manager;

/**
 * Основной класс для запуска приложения
 * Class Application
 * @package App
 */
class Application
{
    private Router $route;

    public function __construct($route)
    {
        $this->route = $route;
        $this->initialize();
    }

    /**
     * Запуск приложения
     */
    public function run(): void
    {
        try {
            $dispatch = $this->route->dispatch();

            if ($dispatch instanceof Renderable) {
                $dispatch->render($dispatch->path);
            } else {
                echo $dispatch;
            }
        } catch (Exception $exception) {
            $this->renderException($exception);
        }
    }

    /**
     * Инициализируем подключение к БД
     */
    private function initialize()
    {
        $capsule = new Manager();

        $capsule->addConnection(
            [
                'driver' => Config::getInstance()->get('db.driver'),
                'host' => Config::getInstance()->get('db.host'),
                'database' => Config::getInstance()->get('db.dbName'),
                'username' => Config::getInstance()->get('db.user'),
                'password' => Config::getInstance()->get('db.password'),
                'charset' => Config::getInstance()->get('db.charset'),
                'collation' => Config::getInstance()->get('db.collation'),
                'prefix' => Config::getInstance()->get('db.prefix')
            ]
        );

        $capsule->setAsGlobal();
        $capsule->bootEloquent();
    }

    /**
     * Вызывается, если не найдена нужная страница
     * @param Exception $exception
     */
    private function renderException(Exception $exception)
    {
        if ($exception instanceof Renderable) {
            /** @noinspection PhpParamsInspection */
            $exception->render();
        } else {
            $code = $exception->getCode() !== 0 ?? 500;
            echo $code . ' ' . $exception->getMessage();
        }
    }
}

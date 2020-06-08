<?php

namespace App;

use Illuminate\Database\Capsule\Manager;
use Exception;

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

    private function initialize()
    {
        $capsule = new Manager();

        $capsule->addConnection(
            [
                'driver' => 'mysql',
                'host' => Config::getInstance()->get('db.host'),
                'database' => Config::getInstance()->get('db.dbName'),
                'username' => Config::getInstance()->get('db.user'),
                'password' => Config::getInstance()->get('db.password'),
                'charset' => 'utf8',
                'collation' => 'utf8_unicode_ci',
                'prefix' => ''
            ]
        );

        $capsule->setAsGlobal();
        $capsule->bootEloquent();
    }

    private function renderException(Exception $exception)
    {
        if ($exception instanceof Renderable) {
            $exception->render();
        } else {
            $code = $exception->getCode() !== 0 ?? 500;
            echo $code . ' ' . $exception->getMessage();
        }
    }
}

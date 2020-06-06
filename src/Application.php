<?php

namespace App;

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
        $dispatch = $this->route->dispatch();

        if ($dispatch instanceof Renderable) {
            $dispatch->render($dispatch->path);
        } else {
            echo $dispatch;
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
}

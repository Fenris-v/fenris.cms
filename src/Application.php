<?php

namespace App;

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
    }

    /**
     * Запуск приложения
     */
    public function run(): void
    {
        $dispatch = $this->route->dispatch();

        if ($dispatch instanceof Renderable) {
            $dispatch->render($dispatch->string);
        } else {
            echo $dispatch;
        }
    }
}

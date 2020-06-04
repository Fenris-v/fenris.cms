<?php

namespace App;

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

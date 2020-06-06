<?php

namespace App;

/**
 * Основной класс роутинга
 * Class Router
 * @package App
 */
class Router
{
    // Массив для хранения доступных путей
    private array $routes = [];

    /**
     * Метод для регистрации доступных пеутей и записи их в массив
     * @param $url - ключ -> ссылка на страницу
     * @param $view - значение -> функция или строка
     */
    public function get($url, $view): void
    {
        if (gettype($view) === 'string') {
            list($class, $method) = explode('@', $view);
            $this->routes[$url] = ['class' => $class, 'method' => $method];
        } else {
            $this->routes[$url] = $view;
        }
    }

    /**
     * Отвечает за запуск правильной $view в соответствии с текущим uri
     * Здесь в else при выполнении анонимной функции заполняется статичный массив $configs класса View
     */
    public function dispatch()
    {
        if (array_key_exists($_SERVER['REQUEST_URI'], $this->routes)) {
            if (is_array($this->routes[$_SERVER['REQUEST_URI']])) {
                $class = new $this->routes[$_SERVER['REQUEST_URI']]['class']();
                $method = $this->routes[$_SERVER['REQUEST_URI']]['method'];
                return $class->$method();
            } else {
                return $this->routes[$_SERVER['REQUEST_URI']]();
            }
        }

        return $this->routes['/']();
    }
}

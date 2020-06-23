<?php

namespace App;

use App\Exception\NotFoundException;

/**
 * Основной класс роутинга
 * Class Router
 * @package App
 */
class Router
{
    /** Массив для хранения доступных путей */
    private array $routes = [];

    /**
     * Добавляет пути для GET
     * @param string $route - адрес страницы
     * @param $callback - callback
     */
    public function get(string $route, $callback): void
    {
        $this->add('get', $route, $callback);
    }

    /**
     * Добавляет пути для POST
     * @param string $route - адрес страницы
     * @param $callback - callback
     */
    public function post(string $route, $callback): void
    {
        $this->add('post', $route, $callback);
    }

    /**
     * Отвечает за запуск метода Route->run()
     * @param string $method - GET/POST
     * @throws NotFoundException - если не найден соответствующий зарегистрированный адрес
     */
    public function dispatch(string $method = 'GET')
    {
        $url = '/' . trim($_SERVER['REQUEST_URI'], '/');
        $method = strtolower($method);

        foreach ($this->routes as $route) {
            if ($route->match($method, $url)) {
                return $route->run($url);
            }
        }

        throw new NotFoundException('Не найден нужный путь', 404);
    }

    /**
     * Метод для регистрации доступных путей и записи их в массив
     * @param string $method - GET/POST
     * @param string $path - ключ -> ссылка на страницу
     * @param $callback - callback
     */
    private function add(string $method, string $path, $callback): void
    {
        $this->routes[] = new Route($method, $path, $callback);
    }
}

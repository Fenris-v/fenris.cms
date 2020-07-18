<?php

namespace App;

/**
 * Class Route
 * @package App
 */
class Route
{
    private string $method;
    private string $path;
    private $callback;

    public function __construct(string $method, string $path, $callback)
    {
        $this->method = $method;
        $this->path = $path;
        $this->callback = $callback;
    }

    /**
     * Возвращает путь текущего объекта
     * @return string - путь
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * Возвращает соответствующий callback
     * @return mixed
     */
    public function getCallback()
    {
        return $this->callback;
    }

    /**
     * Проверяет существует ли объект для заданного адреса и метода
     * @param $method - GET/POST
     * @param $uri - адрес страницы
     * @return bool - существует ли объект
     */
    public function match($method, $uri): bool
    {
        if (stripos($uri, '?')) {
            $uri = stristr($uri, '?', true);
        }
        return $this->method === $method &&
            preg_match('/^' . str_replace(['*', '/'], ['(\w+-?)+', '\/'], $this->getPath()) . '$/', $uri);
    }

    /**
     * Запускает анонимную функцию с нужными параметрами
     * @param $uri - страница
     * @return object|string - анонимная функция с параметрами | результат в случае с параметрами в URL
     */
    public function run(string $uri)
    {
        list($class, $method) = explode('@', $this->getCallback());

        $urlParts = explode('/', $uri);
        $routeParts = explode('/', $this->getPath());

        $params = [];
        foreach ($routeParts as $key => $part) {
            if ($part === '*') {
                $params[] = $urlParts[$key];
            }
        }

        return (new $class)->$method($params);
    }
}

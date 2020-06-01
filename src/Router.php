<?php

namespace App;

class Router
{
    private array $routes = [];

    public function get($url, $view)
    {
        if (gettype($view) === 'string') {
            list($class, $method) = explode('@', $view);
            $this->routes[$url] = ['class' => $class, 'method' => $method];
        } else {
            $this->routes[$url] = $view;
        }
    }

    public function dispatch()
    {
        if (array_key_exists($_SERVER['REQUEST_URI'], $this->routes)) {
            if (is_array($this->routes[$_SERVER['REQUEST_URI']])) {
                $class = new $this->routes[$_SERVER['REQUEST_URI']]['class']();
                $method = $this->routes[$_SERVER['REQUEST_URI']]['method'];
                echo $class->$method();
            } else {
                echo $this->routes[$_SERVER['REQUEST_URI']]();
            }
        }
    }
}

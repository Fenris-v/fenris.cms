<?php

namespace App;

class Router
{
    private array $routes = [];

    public function get($url, $view)
    {
        $this->routes[$url] = $view;
    }

    public function dispatch()
    {
        if (array_key_exists($_SERVER['REQUEST_URI'], $this->routes)) {
            echo $this->routes[$_SERVER['REQUEST_URI']]();
        }
    }
}

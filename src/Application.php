<?php

namespace App;

class Application
{
    private Router $route;

    public function __construct($route)
    {
        $this->route = $route;
    }

    public function run()
    {
        $this->route->dispatch();
    }
}

<?php

namespace App\Controller;

use App\Model\Config;

class ConfigController
{
    /**
     * Устанавливает размер страницы
     */
    public function setPageSize(): void
    {
        $perPage = Config::all()->where('name', 'per_page')->first();
        $perPage->setVal($_POST['per_page']);
        $perPage->save();

        redirectOnPage($_SERVER['REQUEST_URI']);
    }
}

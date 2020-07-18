<?php

namespace App\Controller;

use App\Model\User;

class Controller
{
    /**
     * Возвращает id текущего пользователя
     * @return int
     */
    protected function getCurrentUserId(): int
    {
        return User::all()->where('login', $_SESSION['login'])->first()->id;
    }
}

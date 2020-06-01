<?php

/**
 * На данный момент нигде не применяется
 */
namespace App;

/**
 * Отсюда вызываются нужные для роутинга методы
 * Class Controller
 * @package App
 */
class Controller
{
    /**
     * Выводит главную страницу
     * @return string
     */
    public function index(): string
    {
        return 'home';
    }

    /**
     * Выводит страницу about
     * @return string
     */
    public function about(): string
    {
        return 'about';
    }
}

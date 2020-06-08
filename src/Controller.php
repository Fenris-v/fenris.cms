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
        return function () {
            return new View\View('index', ['title' => 'Index Page']);
        };
    }

    /**
     * Выводит страницу about
     * @return string
     */
    public function about()
    {
        return function () {
            return new View\View('about.about', ['title' => 'About Page']);
        };
    }

    /**
     * Выводит страницу about
     * @return string
     */
    public function news()
    {
        return function () {
            return new View\View('news.news', ['title' => 'News Page']);
        };
    }

    /**
     * Выводит страницу about
     * @return string
     */
    public function books()
    {
        return function () {
            return new View\View('news.news', ['title' => 'News Page']);
        };
    }
}

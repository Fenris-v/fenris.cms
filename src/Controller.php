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
    // TODO: delete not using methods
    /**
     * Возвращает callback для страницы about
     * @return callable - callback
     */
    public function about(): callable
    {
        return function () {
            return new View\View('about.about', ['title' => 'About Page']);
        };
    }

    /**
     * Возвращает callback для страницы news
     * @return callable - callback
     */
    public function news(): callable
    {
        return function () {
            return new View\View('news.news', ['title' => 'News Page']);
        };
    }

    /**
     * Возвращает callback для страницы news с параметрами
     * @return callable - callback
     */
    public function newsParams(): callable
    {
        return function ($param1, $param2) {
            return "Test page with param1=$param1 param2=$param2";
        };
    }

    /**
     * Возвращает callback для страницы books
     * @return callable - callback
     */
    public function books(): callable
    {
        return function () {
            return new View\View('news.news', ['title' => 'News Page']);
        };
    }

    // FOR RELEASE

    /**
     * Возвращает callback для главной страницы
     * @return callable - callback
     */
    public function index(): callable
    {
        return function () {
            return new View\View('index', ['title' => 'Index Page']);
        };
    }

    /**
     * Возвращает callback для страницы post
     * @return callable - callback
     */
    public function post(): callable
    {
        return function ($param) {
            return new View\View('article.article', ['title' => 'Article Page', 'param' => $param]);
        };
    }

    /**
     * Возвращает callback для страницы авторизации
     * @return callable - callback
     */
    public function auth(): callable
    {
        return function () {
            return new View\View('auth.auth', ['title' => 'Authorization']);
        };
    }

    /**
     * Возвращает callback для страницы регистрации
     * @return callable - callback
     */
    public function reg(): callable
    {
        return function () {
            return new View\View('reg.reg', ['title' => 'Registration']);
        };
    }

    /**
     * Возвращает callback для страницы личного кабинета
     * @return callable - callback
     */
    public function profile(): callable
    {
        return function () {
            return new View\View('lk.profile', ['title' => 'Profile']);
        };
    }
}

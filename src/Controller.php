<?php

/**
 * На данный момент нигде не применяется
 */

namespace App;

use App\Model\Article;
use App\Model\Category;

/**
 * Отсюда вызываются нужные для роутинга методы
 * Class Controller
 * @package App
 */
class Controller
{
    /**
     * Возвращает callback для главной страницы
     * @return callable - callback
     */
    public function index(): callable
    {
        return function ($params) {
            return new View\View('index', ['title' => 'Главная страница', 'page' => $params]);
        };
    }

    /**
     * Возвращает callback для страниц категорий
     * @return callable - callback
     */
    public function categories(): callable
    {
        return function ($params) {
            $category = new Category;
            return new View\View(
                'category.category',
                [
                    'title' => $category->getTitle($params[array_key_last($params)]),
                    'metaDescription' => $category->getDescription($params[array_key_last($params)]),
                    'param' => $params
                ]
            );
        };
    }

    /**
     * Возвращает callback для страницы статьи
     * @return callable - callback
     */
    public function article(): callable
    {
        return function ($params) {
            $article = new Article();
            return new View\View(
                'article.article', [
                'title' => $article->getTitle($params[array_key_last($params)]),
                'metaDescription' => $article->getDescription($params[array_key_last($params)]),
                'param' => $params
            ]
            );
        };
    }

    /**
     * Возвращает callback для страниц админки
     * @return callable
     */
    public function admin(): callable
    {
        return function ($params) {
            return new View\View('admin.index', ['params' => $params]);
        };
    }

    /**
     * Возвращает callback для страницы авторизации
     * @return callable - callback
     */
    public function auth(): callable
    {
        return function ($params = '') {
            return new View\View('auth.auth', ['title' => 'Авторизация', 'param' => $params]);
        };
    }

    /**
     * Возвращает callback для страницы правил
     * @return callable - callback
     */
    public function rules(): callable
    {
        return function ($params = '') {
            return new View\View('rules.rules', ['title' => 'Правила пользования сайтом', 'param' => $params]);
        };
    }

    /**
     * Возвращает callback для страницы регистрации
     * @return callable - callback
     */
    public function reg(): callable
    {
        return function () {
            return new View\View('reg.reg', ['title' => 'Регистрация']);
        };
    }

    /**
     * Возвращает callback для страницы личного кабинета
     * @return callable - callback
     */
    public function profile(): callable
    {
        return function ($params) {
            return new View\View('lk.profile', ['title' => 'Личный кабинет', 'param' => $params]);
        };
    }
}

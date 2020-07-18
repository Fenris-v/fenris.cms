<?php

/**
 * На данный момент нигде не применяется
 */

namespace App;

use App\Model\Article;
use App\Model\Category;
use App\View\View;

/**
 * Отсюда вызываются нужные для роутинга методы
 * Class Controller
 * @package App
 */
class Controller
{
    /**
     * Возвращает callback для главной страницы
     * @return View - callback
     */
    public function index(): View
    {
        return new View('index', ['title' => 'Главная страница']);
    }

    /**
     * Возвращает callback для страниц категорий
     * @param $params
     * @return View - callback
     */
    public function categories($params): View
    {
        $category = new Category;
        return new View(
            'category.category',
            [
                'title' => $category->getTitle($params[0]),
                'metaDescription' => $category->getDescription($params[0]),
                'param' => $params
            ]
        );
    }

    /**
     * Возвращает callback для страницы статьи
     * @param $params
     * @return View - callback
     */
    public function article($params): View
    {
        $article = new Article();
        return new View(
            'article.article',
            [
                'title' => $article->getTitle($params[array_key_last($params)]),
                'metaDescription' => $article->getDescription($params[array_key_last($params)]),
                'param' => $params
            ]
        );
    }

    /**
     * Возвращает callback для страниц админки
     * @param $params
     * @return View
     */
    public function admin($params): View
    {
        return new View('admin.index', ['params' => $params]);
    }

    /**
     * Возвращает callback для страницы авторизации
     * @param $params
     * @return View - callback
     */
    public function auth($params): View
    {
        return new View('auth.auth', ['title' => 'Авторизация', 'param' => $params]);
    }

    /**
     * Возвращает callback для страницы правил
     * @param $params
     * @return View - callback
     */
    public function rules($params): View
    {
        return new View('rules.rules', ['title' => 'Правила пользования сайтом', 'param' => $params]);
    }

    /**
     * Возвращает callback для страницы регистрации
     * @return View
     */
    public function reg(): View
    {
        return new View('reg.reg', ['title' => 'Регистрация']);
    }

    /**
     * Возвращает callback для страницы личного кабинета
     * @param $params
     * @return View - callback
     */
    public function profile($params): View
    {
        return new View('lk.profile', ['title' => 'Личный кабинет', 'param' => $params]);
    }
}

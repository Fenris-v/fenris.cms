<?php

namespace App\Model;

use App\Interfaces\GetPage;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Page
 * @package App\Model
 */
class Page extends Model implements GetPage
{
    /**
     * Возвращает заголовок страницы из БД
     * @param $uri - страница
     * @return string - заголовок
     */
    public function getTitle($uri): ?string
    {
        return $this::all()->where('uri', '/' . trim($uri, '/'))->first()->meta_title;
    }

    /**
     * Возвращает описание страницы из БД
     * @param $uri - страница
     * @return string - описание
     */
    public function getDescription($uri): ?string
    {
        return $this::all()->where('uri', $uri)->first()->meta_description;
    }
}

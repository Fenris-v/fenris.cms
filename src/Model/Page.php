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
    public function getTitle(string $uri): ?string
    {
        $page = $this::all()->where('uri', trim($uri, '/'))->first();
        if ($page !== null) {
            return $page->meta_title;
        }

        return null;
    }

    /**
     * Возвращает описание страницы из БД
     * @param $uri - страница
     * @return string - описание
     */
    public function getDescription(string $uri): ?string
    {
        $page = $this::all()->where('uri', trim($uri, '/'))->first();
        if ($page !== null) {
            return $page->meta_description;
        }

        return null;
    }

    /**
     * Проверяет свободен ли такой адрес
     * @param string $uri
     * @param int $id
     * @return bool
     */
    public function isFreeUri(string $uri, int $id = 0): bool
    {
        if ($this::all()->where('id', '!=', $id)->where('uri', $uri)->first() === null) {
            return true;
        }

        return false;
    }
}

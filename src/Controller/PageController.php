<?php

namespace App\Controller;

class PageController extends Controller
{
    /**
     * Транслит для генерации alias
     * @param $page
     * @param string $str - строка на русском/английском
     * @param int $id
     * @return string
     */
    public function generateUri($page, string $str, int $id = 0): string
    {
        $converter = [
            'а' => 'a',
            'б' => 'b',
            'в' => 'v',
            'г' => 'g',
            'д' => 'd',
            'е' => 'e',
            'ё' => 'e',
            'ж' => 'zh',
            'з' => 'z',
            'и' => 'i',
            'й' => 'y',
            'к' => 'k',
            'л' => 'l',
            'м' => 'm',
            'н' => 'n',
            'о' => 'o',
            'п' => 'p',
            'р' => 'r',
            'с' => 's',
            'т' => 't',
            'у' => 'u',
            'ф' => 'f',
            'х' => 'h',
            'ц' => 'c',
            'ч' => 'ch',
            'ш' => 'sh',
            'щ' => 'sch',
            'ь' => '\'',
            'ы' => 'y',
            'ъ' => '\'',
            'э' => 'e',
            'ю' => 'yu',
            'я' => 'ya',
        ];

        $uri = trim(preg_replace('~[^-a-z0-9_]+~u', '-', strtr(mb_strtolower($str), $converter)), '-');

        if (!$page->isFreeUri($uri, $id)) {
            $i = 2;
            while (!$page->isFreeUri($uri . $i, $id)) {
                $i++;
            }
            return $uri . $i;
        }

        return $uri;
    }

    /**
     * Удаляет изображение
     * @param string $image
     */
    protected function removeImage(string $image): void
    {
        if ($image && file_exists($_SERVER['DOCUMENT_ROOT'] . $image)) {
            unlink($_SERVER['DOCUMENT_ROOT'] . $image);
        }

        redirectOnPage($_SERVER['REQUEST_URI']);
    }
}

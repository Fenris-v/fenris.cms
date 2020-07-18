<?php

namespace App\Interfaces;

/**
 * Interface GetPage
 * @package App\Interfaces
 */
interface GetPage
{
    /**
     * Метод получения title
     * @param $uri
     * @return string|null
     */
    public function getTitle(string $uri): ?string;

    /**
     * Метод получения meta_description
     * @param $uri
     * @return string|null
     */
    public function getDescription(string $uri): ?string;

    /**
     * Транслит для генерации alias
     * @param string $str - строка на русском/английском
     * @return string
     */
//    public function generateUri(string $str): string;
}

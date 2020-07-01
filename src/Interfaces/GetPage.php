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
    public function getTitle($uri): ?string;

    /**
     * Метод получения meta_description
     * @param $uri
     * @return string|null
     */
    public function getDescription($uri): ?string;
}

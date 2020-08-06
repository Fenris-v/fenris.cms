<?php

namespace App\Traits;

/**
 * Трейт для загрузки изображений
 * Trait UploadImage
 * @package App\Traits
 */
trait UploadImage
{
    /**
     * Загружает изображение на сервер и возвращает путь к загруженной картинке
     * @param array $image
     * @param string $name
     * @param string $dir
     * @return string
     */
    private function uploadImage(array $image, string $name, string $dir): string
    {
        if (!file_exists(IMAGE_DIR)) {
            mkdir(IMAGE_DIR);
        }

        if (!file_exists($dir)) {
            mkdir($dir);
        }

        $partsName = explode('.', $image['name']);
        $format = $partsName[array_key_last($partsName)];
        $name .= '.' . $format;

        if (in_array($name, scandir($dir))) {
            unlink($dir . $name);
        }

        move_uploaded_file($image['tmp_name'], $dir . $name);

        return $dir === IMAGE_UPLOAD_DIR ? IMAGE_PATH . $name : AVATAR_PATH . $name;
    }
}

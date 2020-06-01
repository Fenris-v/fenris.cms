<?php

// Этот файл подключает все необходимые файлы для конкретной страницы

define('APP_DIR', $_SERVER['DOCUMENT_ROOT']);
define('VIEW_DIR', APP_DIR . '/view/');

/**
 * Функция для регистрации классов и подключения необходимых файлов
 */
spl_autoload_register(
    function ($class) {
        // Префикс пространства имен
        $prefix = 'App\\';

        // Базовый каталог для префикса пространства имен
        $baseDir = __DIR__ . '/src/';

        // Использует ли класс префикс пространства имен?
        $len = strlen($prefix);
        if (strncmp($prefix, $class, $len) !== 0) {
            // Нет, переходим к следующему зарегестрированному автоподгрузчику
            return;
        }

        // Получаем относительное имя класса
        $relativeClass = substr($class, $len);

        // Создаем имя файла
        $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';

        // Если файл существует, то подключаем его
        if (file_exists($file)) {
            /** @noinspection PhpIncludeInspection */
            require $file;
        }
    }
);

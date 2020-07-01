<?php

namespace App\View;

use App\Interfaces\Renderable;

/**
 * Отвечает за вывод запрошенного шаблона
 * Class View
 * @package App
 */
class View implements Renderable
{
    public string $path;
    private array $config;

    public function __construct(string $string, array $config)
    {
        $this->path = $string;
        $this->config = $config;
    }

    /**
     * Создает путь к файлу из строки типа:
     * 'some.dir.some.file'
     * Получается следующий путь:
     * some/dir/some/file.php
     * Если такой файл существует - подключает его
     * @param string $file - строка типа 'some.dir.some.file'
     */
    public function render(string $file): void
    {
        $filePath = VIEW_DIR . str_replace('.', '/', $file) . '.php';

        if (file_exists($filePath)) {
            extract($this->config);
            /** @noinspection PhpIncludeInspection */
            require_once $filePath;
        }
    }
}

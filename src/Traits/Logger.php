<?php

namespace App\Traits;

/**
 * Трейт для ведения логов
 * Trait Logger
 * @package App\Traits
 */
trait Logger
{
    /**
     * Метод для логирования
     * Для логов создается специальная папка log
     * @param string $filename - имя файла в который писать лог
     * @param $log - что писать
     */
    public function logger(string $filename, $log): void
    {
        if (!file_exists(LOG_DIR) && !is_dir(LOG_DIR)) {
            mkdir(LOG_DIR);
        }

        if (!is_string($log)) {
            $this->arrayFormatForLog($log);
        }

        file_put_contents(LOG_DIR . $filename, date('d-m-Y H:i:s - ') . $log . '; ', FILE_APPEND | LOCK_EX);
    }

    /**
     * Преобразование массива в строку
     * @param $log - массив
     */
    private function arrayFormatForLog(array &$log): void
    {
        $log = json_encode($log, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }
}

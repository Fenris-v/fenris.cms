<?php

namespace App;

final class Session
{
    /**
     * Создает сессию
     */
    public function start(): void
    {
        session_start();
    }

    /**
     * Возвращает значение из сессии
     * @param string $key - ключ
     * @return mixed - значение
     */
    public function get(string $key)
    {
        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        }

        return null;
    }

    /**
     * Устанавливает значение в сессию
     * @param string $key - ключ
     * @param $value - значение
     */
    public function set(string $key, $value): void
    {
        $_SESSION[$key] = $value;
    }

    /**
     * Уничтожает сессию
     */
    public function destroy(): void
    {
        session_destroy();
    }
}

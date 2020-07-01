<?php

namespace App;

/**
 * Class Config - Singleton
 * @package App
 */
final class Config
{
    private array $configs = [];
    /** Присваиваем null, т.к. иначе при строгой типизации получим ошибку инициализации переменной */
    private static ?Config $instance = null;

    private function __construct()
    {
        $this->configs['db'] = require CONFIG_DIR . 'db.php';
    }

    private function __clone()
    {
    }

    private function __wakeup()
    {
    }

    /**
     * Получить значение настроек
     * @param $key - название настройки
     * @param null $default - дефолтное значение, если нужного не будет существовать
     * @return mixed|null - значение настройки
     */
    public function getConfig($key, $default = null)
    {
        return $this->configs[$key] ?? $default;
    }

    /**
     * Сохранение новой настройки
     * @param $key - название настройки
     * @param $config - значение настройки
     * @return $this - возвращает этот класс
     */
    public function setConfig($key, $config)
    {
        $this->configs[$key] = $config;
        return $this;
    }

    /**
     * Возвращает результат вспомогательной функции
     * @param $config
     * @param null $default
     * @return array|mixed|string|null
     */
    public function get($config, $default = null)
    {
        return array_get($this->configs, $config, $default);
    }

    /**
     * Возвращает статический массив с настройками
     * @return Config
     */
    public static function getInstance(): Config
    {
        if (null === static::$instance) {
            static::$instance = new static();
        }
        return static::$instance;
    }
}



<?php

namespace App;

/**
 * Class Config - Singleton
 * @package App
 */
final class Config
{
    private array $configs = [];

    public function getConfig($key, $default = null)
    {
        return $this->configs[$key] ?? $default;
    }

    public function setConfig($key, $config)
    {
        $this->configs[$key] = $config;
        return $this;
    }

    /** @var Config */
    // Присваиваем null, т.к. иначе при строгой типизации получим ошибку инициализации переменной
    private static ?Config $instance = null;

    public static function getInstance(): Config
    {
        if (null === static::$instance) {
            static::$instance = new static();
        }
        return static::$instance;
    }

    private function __construct()
    {
        //TODO:
        // По идее можно было сделать вне класса, при помощи метода setConfig()
        // Но я думаю имя данного файла должно быть нередактируемым и потому можно подключить таким образом,
        // не передавая строку с путем к файлу, как мы это делаем в случае с view
        $this->configs['db'] = require CONFIG_DIR . 'db.php';
    }

    private function __clone()
    {
    }

    private function __wakeup()
    {
    }

    public function get($config, $default = null)
    {
        return array_get($this->configs, $config, $default);
    }
}



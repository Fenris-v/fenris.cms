<?php

/**
 * Разбивает строку по разделителю '.'
 * Возвращает значение из массива, где каждый элемент разбитой строки равен ключу в многомерном массиве
 * Точка передает вложенность в многомерный массив
 * @param array $array - массив из которого нужно получить значение
 * @param string $key - строка типа 'db.mysql.host', где каждое значение равно ключу, а точка указывает на вложенность
 * @param string|null $default - значение по умолчанию, будет возвращено, если в массиве не будет соответствующего ключа
 * @return mixed|null - значение массива с соответствующим ключом или значение по умолчанию, если первое не найдено
 */
function array_get(array $array, string $key, string $default = null)
{
    if ($array && $key) {
        $key = explode('.', $key);
        foreach ($key as $keyPart) {
            if (isset($array[$keyPart])) {
                $array = $array[$keyPart];
            } else {
                return $default;
            }
        }

        return $array;
    }

    return $default;
}

/**
 * Функция для подключения частей шаблона
 * @param $templateName - имя шаблона
 * @param $data - передаваемые параметры
 * @throws Exception
 */
function includeView(string $templateName, array $data = [])
{
    if ($templateName) {
        extract($data);
        $path = VIEW_DIR . str_replace('.', '/', $templateName) . '.php';
        if (file_exists($path)) {
            /** @noinspection PhpIncludeInspection */
            require $path;
        } else {
            throw new Exception('Не найден шаблон ' . $templateName, 404);
        }
    } else {
        throw new Exception('В качетсве названия шаблона передана пустая строка', 404);
    }
}

/**
 * Выполняет редирект на главную
 */
function redirectOnMain()
{
    header('location: /');
}

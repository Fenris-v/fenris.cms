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
        throw new Exception('В качестве названия шаблона передана пустая строка', 404);
    }
}

/**
 * Выполняет редирект на указанную страницу
 * @param string $page - страница для перенаправления, по умолчанию - главная
 */
function redirectOnPage($page = '/'): void
{
    header('location: ' . $page);
}

/**
 * Функция для логирования
 * Для логов создается специальная папка log
 * @param string $filename - имя файла в который писать лог
 * @param $log - что писать
 */
function logger(string $filename, $log): void
{
    if (!file_exists(LOG_DIR) && !is_dir(LOG_DIR)) {
        mkdir(LOG_DIR);
    }

    if (!is_string($log)) {
        arrayFormatForLog($log);
    }

    file_put_contents(LOG_DIR . $filename, date('d-m-Y H:i:s - ') . $log . '; ', FILE_APPEND | LOCK_EX);
}

/**
 * Преобразование массива в строку
 * @param $log - массив
 */
function arrayFormatForLog(array &$log): void
{
    $log = json_encode($log, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
}

/**
 * Проверяет действителен ли код для подтверждения регистрации
 * @return bool - действителен ли код
 */
function isSessionLive(): bool
{
    return time() - $_SESSION['secret_code_time'] < SECRET_CODE_LIFE * 60 * 60;
}

/**
 * Возвращает имя view, который нужно подключить
 * @param $section - откуда строить имя
 * @param $params - параметры для имени
 * @return string
 */
function getTemplateName(string $section, array $params): string
{
    foreach ($params as $param) {
        $section .= '.' . $param;

        if ($param === 'edit' || $param === 'list') {
            return $section;
        }
    }
    return $section;
}

/**
 * Делает первую букву строки заглавной (для кириллицы)
 * @param $str - строка для преобразования
 * @return string
 */
function mb_ucfirst(string $str)
{
    return mb_strtoupper(mb_substr($str, 0, 1)) . mb_strtolower(mb_substr($str, 1));
}

function cutStr(string $str, int $length = 20, string $replace = '...'): string
{
    return mb_strimwidth($str, 0, ($length + strlen($replace)), $replace);
}

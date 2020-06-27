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
 * @param string $mode - мод для открытия файла
 */
function logger(string $filename, $log, string $mode = 'w+'): void
{
    if (!file_exists(LOG_DIR) && !is_dir(LOG_DIR)) {
        mkdir(LOG_DIR);
    }

    if (!is_string($log)) {
        arrayFormatForLog($log);
    }

    $handle = fopen(LOG_DIR . $filename, $mode);
    fwrite($handle, $log);
    fclose($handle);
}

/**
 * Преобразование массива в строку
 * @param $log - массив
 */
function arrayFormatForLog(&$log)
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

function generateUri(string $str): string
{
    $converter = [
        'а' => 'a',
        'б' => 'b',
        'в' => 'v',
        'г' => 'g',
        'д' => 'd',
        'е' => 'e',
        'ё' => 'e',
        'ж' => 'zh',
        'з' => 'z',
        'и' => 'i',
        'й' => 'y',
        'к' => 'k',
        'л' => 'l',
        'м' => 'm',
        'н' => 'n',
        'о' => 'o',
        'п' => 'p',
        'р' => 'r',
        'с' => 's',
        'т' => 't',
        'у' => 'u',
        'ф' => 'f',
        'х' => 'h',
        'ц' => 'c',
        'ч' => 'ch',
        'ш' => 'sh',
        'щ' => 'sch',
        'ь' => '\'',
        'ы' => 'y',
        'ъ' => '\'',
        'э' => 'e',
        'ю' => 'yu',
        'я' => 'ya',
    ];

    return preg_replace('~[^-a-z0-9_]+~u', '-', strtr(mb_strtolower($str), $converter));
}

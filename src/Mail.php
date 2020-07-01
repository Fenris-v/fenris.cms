<?php

namespace App;

/**
 * Класс для отправки писем
 * Class Mail
 * @package App
 */
class Mail
{
    public function sendMail($to, $subject, $message, $from)
    {
        $headers  = "Content-type: text/html; charset=utf-8 \r\n";
        $headers .= "From: " . $from . "\r\n";

        mail($to, $subject, $message, $headers);
    }

    public function generateSecretCode(): string
    {
        return rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9);
    }

    public function textForSecretCodeMsg($name, $code)
    {
        $name = $name ?? 'пользователь';
        return '<p>Привет, ' . $name . '! Ваш адрес был указан для регистрации на сайте '
            . $_SERVER['HTTP_HOST']
            . '. Чтобы подтвердить регистрацию, пожалуйста, введите код безопасности, указанный ниже.</p>
            <p>Код действителен в течение <strong>' . SECRET_CODE_LIFE . ' минут</strong>.</p>
            <p>Ваш код безопасности:</p>
            <p>' . $code . '</p>';
    }
}

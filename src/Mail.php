<?php

namespace App;

use App\Model\Article;
use App\Model\Category;
use App\Model\Subscribe;

/**
 * Класс для отправки писем
 * Class Mail
 * @package App
 */
class Mail
{
    /**
     * Отправляет письма
     * @param string $to - кому
     * @param string $subject - тема
     * @param string $message - сообщение
     * @param string $from
     */
    public function sendMail(string $to, string $subject, string $message, string $from): void
    {
        $headers = "Content-type: text/html; charset=utf-8 \r\n";
        $headers .= "From: " . $from . "\r\n";

        mail($to, $subject, $message, $headers);
    }

    /**
     * Генерирует секретный код для подтверждения действий с учетной записью
     * @return string
     */
    public function generateSecretCode(): string
    {
        return rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9);
    }

    /**
     * Текст письма для письма с секретным кодом
     * @param string $name - имя пользователя
     * @param string $code
     * @return string
     */
    public function textForSecretCodeMsg(string $name, string $code): string
    {
        $name = $name ?? 'пользователь';
        return '<p>Привет, ' . $name . '! Ваш адрес был указан для регистрации на сайте '
            . $_SERVER['HTTP_HOST']
            . '. Чтобы подтвердить регистрацию, пожалуйста, введите код безопасности, указанный ниже.</p>
            <p>Код действителен в течение <strong>' . SECRET_CODE_LIFE . ' минут</strong>.</p>
            <p>Ваш код безопасности:</p>
            <p>' . $code . '</p>';
    }

    /**
     * Рассылка
     * @param string $uri
     */
    public function mailing(string $uri): void
    {
        $article = Article::all()->where('uri', $uri)->first();
        $subject = 'На сайте добавлена новая запись: “' . $article->title . '”';
        $protocol = isset($_SERVER['HTTPS']) ? 'https://' : 'http://' ;
        $link = $protocol . $_SERVER['HTTP_HOST'] . '/'
            . Category::all()
                ->where('id', $article->category_id)
                ->first()
                ->uri . '/' . $article->uri;

        foreach (Subscribe::all() as $subscribe) {
            $unsubscribeLink = $protocol . $_SERVER['HTTP_HOST'] . '/?unsubscribe&id=' . $subscribe->id . '&mail=' . $subscribe->mail;

            $text = '<p>Новая статья: “' . $article->title . '”</p>'
                . $article->short_desc
                . '<a href="' . $link . '">Читать</a>'
                . '<a href="' . $unsubscribeLink . '">Отписаться от рассылки</a>';

            $this->sendMail($subscribe->mail, $subject, $text, BLOG_MAIL);
        }
    }
}

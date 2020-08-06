<?php

namespace App\Controller;

use App\Exception\DataException;
use App\Exception\SaveException;
use App\Model\Subscribe;
use App\Model\User;

class SubscribeController
{
    /**
     * Создает или отменяет подписку на рассылку
     * @return bool
     * @throws SaveException
     * @throws DataException
     */
    public function changeSubscribe(): void
    {
        if (isset($_SESSION['login']) && !isset($_SESSION['secret_code'])) {
            $userMail = User::all()
                ->where('login', $_SESSION['login'])
                ->first()
                ->mail;
            if (isset($_POST['unsubscribe'])) {
                $subscribe = Subscribe::all()
                    ->where('mail', $userMail)
                    ->first();
                $success = $subscribe->delete();
            } else {
                if (Subscribe::all()->where('mail', $userMail)->first() !== null) {
                    return;
                }

                $subscribe = (new Subscribe())
                    ->setMail($userMail);
                $success = $subscribe->save();
            }

            if (!$success) {
                throw new SaveException('Ошибка сохранения данных', 500);
            }

            return;
        }

        if (isset($_POST['subscribe'])) {
            if (!$_POST['mail']) {
                throw new DataException(['mail' => 'Введите почту']);
            } elseif (
                Subscribe::all()->where('mail', trim($_POST['mail']))->first() !== null
            ) {
                throw new DataException(['mail' => 'На данный адрес уже оформлена подписка']);
            }

            $subscribe = (new Subscribe())
                ->setMail(trim($_POST['mail']));
            $success = $subscribe->save();

            if (!$success) {
                throw new SaveException('Ошибка сохранения данных', 500);
            }
        }

        redirectOnPage($_SERVER['REQUEST_URI']);
    }

    /**
     * Отписывает от рассылки по ссылке
     * @throws SaveException
     */
    public function unsubscribe(): void
    {
        $subscribe = Subscribe::all()->where('id', $_GET['id'])->where('mail', $_GET['mail'])->first();

        if ($subscribe === null) {
            throw new SaveException('Ошибка сохранения данных', 500);
        }

        $success = $subscribe->delete();

        if (!$success) {
            throw new SaveException('Ошибка сохранения данных', 500);
        }

        redirectOnPage($_SERVER['REQUEST_URI']);
    }
}

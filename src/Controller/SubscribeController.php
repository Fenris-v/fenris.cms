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
    public function changeSubscribe(): bool
    {
        if (isset($_SESSION['login'])) {
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
                    return true;
                }

                $subscribe = (new Subscribe())
                    ->setMail($userMail);
                $success = $subscribe->save();
            }

            if (!$success) {
                throw new SaveException('Ошибка сохранения данных', 500);
            }

            return true;
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

            return true;
        }

        return false;
    }

    /**
     * Отписывает от рассылки по ссылке
     * @throws SaveException
     */
    public function unsubscribe(): bool
    {
        $subscribe = Subscribe::all()->where('id', $_GET['id'])->where('mail', $_GET['mail'])->first();

        if ($subscribe === null) {
            return true;
        }

        $success = $subscribe->delete();

        if (!$success) {
            throw new SaveException('Ошибка сохранения данных', 500);
        }

        return true;
    }
}

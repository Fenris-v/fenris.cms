<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * Модель управления подписками
 * Class Subscribe
 * @package App\Model
 */
class Subscribe extends Model
{
    public $timestamps = false;

    /**
     * Создает или отменяет подписку на рассылку
     * @return string|null
     */
    public function changeSubscribe(): ?string
    {
        if (isset($_SESSION['login'])) {
            $userMail = User::all()
                ->where('login', $_SESSION['login'])
                ->first()
                ->mail;

            if (isset($_POST['unsubscribe'])) {
                $subscribe = $this::all()
                    ->where('mail', $userMail)
                    ->first();
                $subscribe->delete();
            } else {
                if ($this::all()->where('mail', $userMail)->first() !== null) {
                    return null;
                }

                $subscribe = new $this;
                $subscribe->mail = $userMail;
                $subscribe->save();
            }

            return null;
        }

        if (isset($_POST['subscribe'])) {
            if (!$_POST['mail']) {
                return 'Введите почту';
            } elseif (
                $this::all()->where('mail', trim($_POST['mail']))->first() !== null
            ) {
                return 'На данный адрес уже оформлена подписка';
            }

            $subscribe = new $this;
            $subscribe->mail = trim($_POST['mail']);
            $subscribe->save();
        }

        return null;
    }

    /**
     * Отписывает от рассылки по ссылке
     */
    public function unsubscribe(): void
    {
        $subscribe = $this::all()->where('id', $_GET['id'])->where('mail', $_GET['mail'])->first();

        if ($subscribe === null) {
            return;
        }

        $subscribe->delete();
    }
}

<?php

namespace App\Model;

use App\Session;
use Illuminate\Database\Eloquent\Model;

final class User extends Model
{
    /**
     * Выполняет вход в аккаунт
     */
    public function signIn(): void
    {
        if ($this->verifyAuthData()) {
            if ($this->loginType() === 'mail') {
                (new Session())->set(
                    'login',
                    $this::all()
                        ->where($this->loginType(), $_POST['username'])
                        ->first()
                        ->login
                );
            } else {
                (new Session())->set('login', $_POST['username']);
            }

            redirectOnMain();
        }
    }

    // TODO: Реализовать запоминание аккаунта
    public function remember(): void
    {
    }

    /**
     * Сверяет логин и пароль
     * @return bool true - если пара верна, false - если не совпадает / не существует
     */
    private function verifyAuthData(): bool
    {
        if ($_POST['username'] && $_POST['password']) {
            $user = $this::all()->where($this->loginType(), $_POST['username'])->first();
            if ($user) {
                return password_verify($_POST['password'], $user->password);
            }
        }

        return false;
    }

    /**
     * Возвращает тип логина
     * @return string - почта или логин
     */
    private function loginType(): string
    {
        return filter_var($_POST['username'], FILTER_VALIDATE_EMAIL) ? 'mail' : 'login';
    }
}

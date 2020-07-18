<?php

namespace App\Controller;

use App\Exception\DataException;
use App\Exception\SaveException;
use App\Mail;
use App\Model\User;
use App\Session;

class UserController
{
    /**
     * Редактирование профиля в личном кабинете
     * @param string $login
     * @return bool
     * @throws DataException
     * @throws SaveException
     */
    public function minEdit(string $login): bool
    {
        $user = User::all()->where('login', $login)->first();

        if (!filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)) {
            throw new DataException(['mail' => 'Не правильный формат почты']);
        } elseif (
            User::all()
                ->where('login', '!=', $login)
                ->where('mail', $_POST['mail'])
                ->first() !== null
        ) {
            throw new DataException(['mail' => 'Данная почта принадлежит другому пользователю']);
        }

        $user->setName(trim($_POST['name']))
            ->setMail(trim($_POST['mail']))
            ->setAbout(trim($_POST['aboutUser']));

        $success = $user->save();

        if (!$success) {
            throw new SaveException('Ошибка сохранения данных', 500);
        }

        return true;
    }

    /**
     * Загружает аватар пользователя
     * @param $login
     * @return bool
     * @throws SaveException
     * @throws DataException
     */
    public function uploadAvatar($login): bool
    {
        if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
            if ($_FILES['image']['size'] > AVATAR_MAX_SIZE_B) {
                throw new DataException(['image' => 'Максимальный размер изображения ' . AVATAR_MAX_SIZE . 'мб']);
            } elseif (!in_array(mime_content_type($_FILES['image']['tmp_name']), ALLOWED_IMAGES)) {
                throw new DataException(['image' => 'Недопустимое расширение файла']);
            }
        }

        $image = $this->uploadImage($_FILES['image'], $login);

        $user = User::all()->where('login', $login)->first();
        $user->setAvatar($image);
        $success = $user->save();

        if (!$success) {
            throw new SaveException('Ошибка сохранения данных', 500);
        }

        return true;
    }

    /**
     * Выполняет вход в аккаунт
     * @return bool
     * @throws DataException
     */
    public function auth(): bool
    {
        if ($this->verifyAuthData()) {
            $user = User::all()
                ->where($this->loginType(), $_POST['username'])
                ->first();

            $login = $this->loginType() === 'login'
                ? $_POST['username']
                : $user->login;

            $session = new Session();
            $session->set('login', $login);

            if (isset($_POST['remember'])) {
                $this->remember($login, $_POST['password']);
            } else {
                setcookie('password_token', '', time() - 3600);
                $this->removeToken($login);
            }

            redirectOnPage();
            return true;
        } else {
            throw new DataException(['auth' => 'Не правильный логин или пароль']);
        }
    }

    /**
     * Регистрирует пользователя
     * @return bool
     * @throws DataException
     */
    public function registration(): bool
    {
        $error = $this->checkData();

        if (!empty($error)) {
            throw new DataException($error);
        }

        if (!isset($_SESSION['secret_code']) || !isSessionLive()) {
            $this->writeCode($_POST['email'], $_POST['username']);
        }

        $_SESSION['mail'] = $_POST['email'];
        $_SESSION['login'] = $_POST['username'];
        $_SESSION['password'] = $_POST['password'];

        return true;
    }

    /**
     * Проверяет есть ли такой пользователь и отправляет письмо с кодом для восстановления пароля
     * @return void
     * @throws DataException
     */
    public function forgetPassword(): void
    {
        $user = User::all()
            ->where($this->loginType(), $_POST['username'])
            ->first();
        if ($user) {
            $this->writeCode($user->mail, $user->login);
            $_SESSION['forgetting_user'] = $user->mail;
            return;
        }

        throw new DataException([], 'Пользователь не найден', 400);
    }

    /**
     * Генерирует и отправляет новый код
     */
    public function newCode()
    {
        if (isset($_SESSION['mail']) && $_SESSION['login']) {
            $this->writeCode($_SESSION['mail'], $_SESSION['login']);
        } else {
            $this->writeCode(
                $_SESSION['forgetting_user'],
                User::all()
                    ->where('mail', $_SESSION['forgetting_user'])
                    ->first()
                    ->login
            );
        }
    }

    /**
     * Проверяет код из письма
     * @return bool
     * @throws DataException
     */
    public function checkCode(): bool
    {
        if (isset($_SESSION['secret_code']) && isset($_SESSION['secret_code_time'])) {
            if (!isSessionLive()) {
                throw new DataException(['code' => 'Время действия кода истекло']);
            } elseif ($_SESSION['secret_code'] !== $_POST['secret']) {
                throw new DataException(['code' => 'Не правильный код']);
            }
            $this->create();
        }

        return true;
    }

    /**
     * Быстрый вход (когда был выбран чекбокс "запомнить меня")
     */
    public function fastAuth(): void
    {
        $user = User::all()
            ->where('password_token', $_COOKIE['password_token'])
            ->first();

        if (!isset($user)) {
            setcookie('password_token', '', time() - 3600, '/');
            return;
        }

        $_SESSION['login'] = $user->login;
    }

    /**
     * Сбрасывает пароль
     * @return bool
     */
    public function resetPassword(): bool
    {
        $password = $this->checkPassword($_POST['new_password']);
        if ($password === null) {
            $user = User::all()
                ->where('mail', $_SESSION['forgetting_user'])
                ->first();

            $user->update(['password' => password_hash($_POST['new_password'], PASSWORD_DEFAULT)]);

            session_destroy();
            session_start();

            $_SESSION['password_reset'] = 'success';

            $_POST['test'] = 'test';

            redirectOnPage('/auth');

            unset($_SESSION['forgetting_user']);
        }

        return true;
    }

    /**
     * Устанавливает новые значения для пользователя
     * @param int $userId - id пользователя
     * @return bool
     * @throws DataException
     * @throws SaveException
     */
    public function setNewData(int $userId): bool
    {
        $user = User::all()->where('id', $userId)->first();

        $error = $this->checkEditData($userId);

        if (!empty($error)) {
            throw new DataException($error);
        }

        if ($_SESSION['login'] === $user->login) {
            $_SESSION['login'] = trim($_POST['login']);
        }

        $user->setName($_POST['name'])
            ->setMail($_POST['email'])
            ->setRoleId($_POST['role'])
            ->setLogin($_POST['username']);

        $success = $user->save();

        if (!$success) {
            throw new SaveException('Ошибка сохранения данных', 500);
        }

        header('Refresh: 0');

        return true;
    }

    /**
     * Удаляет аватар и картинку
     * @param string $login
     * @throws SaveException
     */
    public function removeAvatar(string $login): void
    {
        $user = User::all()->where('login', $login)->first();

        if ($user->avatar && file_exists($_SERVER['DOCUMENT_ROOT'] . $user->avatar)) {
            unlink($_SERVER['DOCUMENT_ROOT'] . $user->avatar);
        }

        $user->setAvatar('');
        $success = $user->save();

        if (!$success) {
            throw new SaveException('Ошибка сохранения данных', 500);
        }
    }

    /**
     * Проверяет данные при изменении юзера через админку
     * @param int $userId
     * @return array
     */
    private function checkEditData(int $userId): array
    {
        $errors = [];

        if (!trim($_POST['email'])) {
            $errors['mail'] = 'Почта не может быть пустой';
        } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['mail'] = 'Некорректный адрес';
        } elseif (
            User::all()
                ->where('id', '!=', $userId)
                ->where('mail', $_POST['email'])
                ->first() !== null
        ) {
            $errors['mail'] = 'Данная почта уже занята';
        }

        if (!trim($_POST['username'])) {
            $errors['login'] = 'Логин не может быть пустым';
        } elseif (
            User::all()
                ->where('id', '!=', $userId)
                ->where('login', $_POST['username'])
                ->first() !== null
        ) {
            $errors['mail'] = 'Данный логин уже занят';
        }

        return $errors;
    }

    /**
     * Создает нового пользователя
     */
    private function create(): void
    {
        $user = (new User())
            ->setLogin($_SESSION['login'])
            ->setPassword(password_hash($_SESSION['password'], PASSWORD_DEFAULT))
            ->setMail($_SESSION['mail']);
        $user->save();

        unset($_SESSION['password']);
        unset($_SESSION['mail']);
        unset($_SESSION['secret_code']);
        unset($_SESSION['secret_code_time']);

        $_SESSION['final_reg'] = 'success';
    }

    /**
     * Отправляет письмо с кодом на почту и пишет его в сессию
     * @param $to - почта, на которую отправляется код
     * @param $user - имя пользователя
     */
    private function writeCode(string $to, string $user): void
    {
        $mail = new Mail();
        $code = $mail->generateSecretCode();
        $msg = $mail->textForSecretCodeMsg($user, $code);
        $mail->sendMail($to, 'Подтверждение почты', $msg, NO_REPLY_MAIL);

        $_SESSION['secret_code'] = $code;
        $_SESSION['secret_code_time'] = time();
    }

    /**
     * Загружает изображение на сервер и возвращает путь к загруженной картинке
     * @param $image
     * @param $name
     * @return string
     */
    private function uploadImage(array $image, string $name): string
    {
        if (!file_exists(IMAGE_DIR)) {
            mkdir(IMAGE_DIR);
        }

        if (!file_exists(AVATAR_UPLOAD_DIR)) {
            mkdir(AVATAR_UPLOAD_DIR);
        }

        $partsName = explode('.', $image['name']);
        $format = $partsName[array_key_last($partsName)];
        $name .= '.' . $format;

        if (in_array($name, scandir(AVATAR_UPLOAD_DIR))) {
            unlink(AVATAR_UPLOAD_DIR . $name);
        }

        move_uploaded_file($image['tmp_name'], AVATAR_UPLOAD_DIR . $name);

        return AVATAR_PATH . $name;
    }

    /**
     * "Запомнить меня" - запись токена в БД
     * @param $login - логин пользователя
     * @param $password - пароль для создания md5
     */
    private function remember(string $login, string $password): void
    {
        $password_token = md5($login . $password . time());

        User::all()
            ->where('login', $login)
            ->first()
            ->update(['password_token' => $password_token]);

        setcookie('password_token', $password_token, time() + (30 * 24 * 60 * 60), '/');
    }

    /**
     * Удаляет токен для "запоминания" пользователя из БД
     * @param $login - логин пользователя, для которого удалить токен
     */
    private function removeToken(string $login): void
    {
        User::all()
            ->where('login', $login)
            ->first()
            ->update(['password_token' => null]);
    }

    /**
     * Сверяет логин и пароль
     * @return bool true - если пара верна, false - если не совпадает / не существует
     */
    private function verifyAuthData(): bool
    {
        if ($_POST['username'] && $_POST['password']) {
            $user = User::all()->where($this->loginType(), $_POST['username'])->first();
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

    /**
     * Возвращает ошибки данных
     * @return array
     */
    private function checkData(): array
    {
        $errors = [];

        $mail = $this->checkMail($_POST['email']);
        if ($mail) {
            $errors['mail'] = $mail;
        }

        $login = $this->checkLogin($_POST['username']);
        if ($login) {
            $errors['login'] = $login;
        }

        $password = $this->checkPassword($_POST['password']);
        if ($password) {
            $errors['password'] = $password;
        }

        return $errors;
    }

    /**
     * Проверяет почту для регистрации
     * @param $mail - почта
     * @return string|null - текст ошибки
     */
    private function checkMail(string $mail): ?string
    {
        if (!isset($mail) || empty($mail)) {
            return 'Введите почту';
        } elseif (!filter_var($mail)) {
            return 'Некорректная почта';
        } elseif (User::all()->where('mail', trim($mail))->first() !== null) {
            return 'Указанная почта уже зарегистрирована';
        }

        return null;
    }

    /**
     * Проверяет логин для регистрации
     * @param $login - логин
     * @return string|null - текст ошибки
     */
    private function checkLogin(string $login): ?string
    {
        if (!isset($login) || empty($login)) {
            return 'Введите логин';
        } elseif (strlen($login) < MIN_LOGIN_LENGTH) {
            return 'Минимальная длина логина - ' . MIN_LOGIN_LENGTH . ' символа';
        } elseif (!preg_match("/^[A-Za-z0-9\-_]+$/", $login)) {
            return 'Допустимы только латинские буквы, цифры и символы - и _';
        } elseif (User::all()->where('login', trim($_POST['username']))->first() !== null) {
            return 'Имя уже занято';
        }

        return null;
    }

    /**
     * Проверяет пароль для регистрации
     * @param $password - пароль
     * @return string|null - текст ошибки
     */
    private function checkPassword(string $password): ?string
    {
        if (!isset($password) || empty($password)) {
            return 'Введите пароль';
        } elseif (strlen($password) < MIN_PASSWORD_LENGTH) {
            return 'Минимальная длина пароля - ' . MIN_PASSWORD_LENGTH . ' символов';
        } elseif (preg_match('/[а-яё]/iu', $password)) {
            return 'Использование букв кириллицы в пароле не допускается';
        }

        return null;
    }
}

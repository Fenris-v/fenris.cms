<?php

namespace App\Model;

use App\Mail;
use App\Session;
use Illuminate\Database\Eloquent\Model;

/**
 * Class User - Singleton
 * @package App\Model
 */
final class User extends Model
{
    public static ?User $instance = null;
    public static ?string $role = null;
    protected $fillable = ['password_token', 'password', 'mail', 'role_id', 'updated_at'];

    /**
     * Делать класс синглтоном
     * @return User
     */
    public static function getInstance(): User
    {
        if (null === static::$instance) {
            static::$instance = new static();
        }
        return static::$instance;
    }

    /**
     * Возвращает имя пользователя, если оно пустое - логин
     * @return string - имя или логин
     */
    public function getName(): string
    {
        $name = $this::all()
            ->where('login', $_SESSION['login'])
            ->first()
            ->name;

        if ($name !== null && $name) {
            return $name;
        }

        return $this::all()
            ->where('login', $_SESSION['login'])
            ->first()
            ->login;
    }

    /**
     * Возвращает название роли
     * @param int $id
     * @return string
     */
    public function getRoleName(int $id): string
    {
        return (new Role())->getRoleVisibleName(
            $this::all()
                ->where('id', $id)
                ->first()
                ->role_id
        );
    }

    /**
     * Проверяет является ли пользователь менеджером
     * @return bool
     */
    public function isManager(): bool
    {
        if (static::$role === null) {
            static::$role = $this->getUserRole();
        }

        if (static::$role === 'manager') {
            return true;
        }

        return false;
    }

    /**
     * Проверяет является ли пользователь администратором
     * @return bool
     */
    public function isSuperUser(): bool
    {
        if (static::$role === null) {
            static::$role = $this->getUserRole();
        }

        if (static::$role === 'admin') {
            return true;
        }

        return false;
    }

    /**
     * Выполняет вход в аккаунт
     */
    public function auth(): ?string
    {
        if ($this->verifyAuthData()) {
            $user = $this::all()
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
            return null;
        } else {
            return 'Не правильный логин или пароль';
        }
    }

    /**
     * Быстрый вход (когда был выбран чекбокс "запомнить меня")
     */
    public function fastAuth(): void
    {
        $user = $this::all()
            ->where('password_token', $_COOKIE['password_token'])
            ->first();

        if (!isset($user)) {
            setcookie('password_token', '', time() - 3600, '/');
            return;
        }

        $_SESSION['login'] = $user->login;
    }

    /**
     * Регистрирует пользователя
     * @return array|null
     */
    public function registration(): ?array
    {
        $error = [];

        $mail = $this->checkMail($_POST['email']);
        if ($mail) {
            $error['mail'] = $mail;
        }

        $login = $this->checkLogin($_POST['username']);
        if ($login) {
            $error['login'] = $login;
        }

        $password = $this->checkPassword($_POST['password']);
        if ($password) {
            $error['password'] = $password;
        }

        if (!empty($error)) {
            return $error;
        }

        if (!isset($_SESSION['secret_code']) || !isSessionLive()) {
            $this->writeCode($_POST['email'], $_POST['username']);
        }

        $_SESSION['mail'] = $_POST['email'];
        $_SESSION['login'] = $_POST['username'];
        $_SESSION['password'] = $_POST['password'];

        return null;
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
                $this::all()
                    ->where('mail', $_SESSION['forgetting_user'])
                    ->first()
                    ->login
            );
        }
    }

    /**
     * Проверяет код из письма
     * @return string|null - текст ошибки
     */
    public function checkCode(): ?string
    {
        if (isset($_SESSION['secret_code']) && isset($_SESSION['secret_code_time'])) {
            if (!isSessionLive()) {
                return 'Время действия кода истекло';
            } elseif ($_SESSION['secret_code'] !== $_POST['secret']) {
                return 'Не правильный код';
            }
            $this->create();
        }

        return null;
    }

    /**
     * Проверяет есть ли такой пользователь и отправляет письмо с кодом для восстановления пароля
     * @return string|null - ошибки
     */
    public function forgetPassword(): ?string
    {
        $user = $this::all()
            ->where($this->loginType(), $_POST['username'])
            ->first();
        if ($user) {
            $this->writeCode($user->mail, $user->login);
            $_SESSION['forgetting_user'] = $user->mail;
            return null;
        }

        return 'Не найден такой пользователь';
    }

    /**
     * Сбрасывает пароль
     * @return string|null - сообщения
     */
    public function resetPassword(): ?string
    {
        $password = $this->checkPassword($_POST['new_password']);
        if ($password === null) {
            $user = $this::all()
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

        return $password;
    }

    /**
     * Устанавливает новые значения для пользователя
     * @param $userId - id пользователя
     * @return array - ошибки или пустой массив
     */
    public function setNewData(int $userId): array
    {
        $user = $this::all()->where('id', $userId)->first();

        $error = [];

        if (!filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)) {
            $error['mail'] = 'Неверный адрес';
        } elseif (
            $user->mail !== trim($_POST['mail']) &&
            $this::all()->where('mail', trim($_POST['mail']))->first() !== null
        ) {
            $error['mail'] = 'Другой пользователь использует данный адрес';
        }

        if (strlen(trim($_POST['login'])) < 4) {
            $error['login'] = 'Слишком короткий логин';
        } elseif (
            $user->login !== trim($_POST['login']) &&
            $this::all()->where('login', trim($_POST['login']))->first() !== null
        ) {
            $error['login'] = 'Данный логин занят';
        }

        if (!empty($error)) {
            return $error;
        }

        if ($_SESSION['login'] === $user->login) {
            $_SESSION['login'] = trim($_POST['login']);
        }

        $user->name = $_POST['name'];
        $user->mail = $_POST['mail'];
        $user->role_id = $_POST['role'];
        $user->subscribe = isset($_POST['subscribe']);
        $user->login = $_POST['login'];

        $user->save();

        header('Refresh: 0');

        return $error;
    }

    public function changeSubscribe(): void
    {
        $user = $this::all()->where('login', $_SESSION['login'])->first();

        if (isset($_POST['subscribe'])) {
            $user->subscribe = 1;
        } else {
            $user->subscribe = 0;
        }

        $user->save();
    }

    /**
     * Возвращает id роли пользователя
     * @return int
     */
    public function getRoleId(): int
    {
        return (int)$this::all()->where('login', $_SESSION['login'])->first()->role_id;
    }

    public function minEdit(string $login): array
    {
        $error = [];

        $user = $this::all()->where('login', $login)->first();

        if (!filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)) {
            $error['mail'] = 'Не правильный формат почты';
        } elseif (
            $this::all()
                ->where('login', '!=', $login)
                ->where('mail', $_POST['mail'])
                ->first() !== null
        ) {
            $error['mail'] = 'Данная почта принадлежит другому пользователю';
        }

        if (!empty($error)) {
            return $error;
        }

        $user->name = trim($_POST['name']);
        $user->mail = trim($_POST['mail']);
        $user->about = trim($_POST['aboutUser']);

        $user->save();

        return $error;
    }

    /**
     * Удаляет аватар и картинку
     * @param string $login
     */
    public
    function removeAvatar(
        string $login
    ): void {
        $user = $this::all()->where('login', $login)->first();

        if ($user->avatar && file_exists($_SERVER['DOCUMENT_ROOT'] . $user->avatar)) {
            unlink($_SERVER['DOCUMENT_ROOT'] . $user->avatar);
        }

        $user->avatar = '';
        $user->save();
    }

    /**
     * Загружает аватар пользователя
     * @param $login
     * @return string|null
     */
    public
    function setAvatar(
        $login
    ): ?string {
        if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
            if ($_FILES['image']['size'] > AVATAR_MAX_SIZE_B) {
                return 'Максимальный размер изображения ' . AVATAR_MAX_SIZE . 'мб';
            } elseif (!in_array(mime_content_type($_FILES['image']['tmp_name']), ALLOWED_IMAGES)) {
                return 'Недопустимое расширение файла';
            }
        }

        $image = $this->uploadImage($_FILES['image'], $login);

        $user = $this::all()->where('login', $login)->first();
        $user->avatar = $image;
        $user->save();

        return null;
    }

    /**
     * Загружает изображение на сервер и возвращает путь к загруженной картинке
     * @param $image
     * @param $name
     * @return string
     */
    private
    function uploadImage(
        array $image,
        string $name
    ): string {
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
     * Возвращает роль пользователя
     * @return string
     */
    private
    function getUserRole(): string
    {
        return (new Role())->getRoleName(
            $this::all()
                ->where('login', $_SESSION['login'])
                ->first()
                ->role_id
        );
    }

    /**
     * Отправляет письмо с кодом на почту и пишет его в сессию
     * @param $to - почта, на которую отправляется код
     * @param $user - имя пользователя
     */
    private
    function writeCode(
        string $to,
        string $user
    ) {
        $mail = new Mail();
        $code = $mail->generateSecretCode();
        $msg = $mail->textForSecretCodeMsg($user, $code);
        $mail->sendMail($to, 'Подтверждение почты', $msg, NO_REPLY_MAIL);

        $_SESSION['secret_code'] = $code;
        $_SESSION['secret_code_time'] = time();
    }

    /**
     * Создает нового пользователя
     */
    private
    function create(): void
    {
        $user = new $this;
        $user->login = $_SESSION['login'];
        $user->password = password_hash($_SESSION['password'], PASSWORD_DEFAULT);
        $user->mail = $_SESSION['mail'];
        $user->save();

        unset($_SESSION['password']);
        unset($_SESSION['mail']);
        unset($_SESSION['secret_code']);
        unset($_SESSION['secret_code_time']);

        $_SESSION['final_reg'] = 'success';
    }

    /**
     * Проверяет почту для регистрации
     * @param $mail - почта
     * @return string|null - текст ошибки
     */
    private
    function checkMail(
        string $mail
    ): ?string {
        if (!isset($mail) || empty($mail)) {
            return 'Введите почту';
        } elseif (!filter_var($mail)) {
            return 'Некорректная почта';
        } elseif ($this::all()->where('mail', trim($mail))->first() !== null) {
            return 'Указанная почта уже зарегистрирована';
        }

        return null;
    }

    /**
     * Проверяет логин для регистрации
     * @param $login - логин
     * @return string|null - текст ошибки
     */
    private
    function checkLogin(
        string $login
    ): ?string {
        if (!isset($login) || empty($login)) {
            return 'Введите логин';
        } elseif (strlen($login) < MIN_LOGIN_LENGTH) {
            return 'Минимальная длина логина - ' . MIN_LOGIN_LENGTH . ' символа';
        } elseif (!preg_match("/^[A-Za-z0-9\-_]+$/", $login)) {
            return 'Допустимы только латинские буквы, цифры и символы - и _';
        } elseif ($this::all()->where('login', trim($_POST['username']))->first() !== null) {
            return 'Имя уже занято';
        }

        return null;
    }

    /**
     * Проверяет пароль для регистрации
     * @param $password - пароль
     * @return string|null - текст ошибки
     */
    private
    function checkPassword(
        string $password
    ): ?string {
        if (!isset($password) || empty($password)) {
            return 'Введите пароль';
        } elseif (strlen($password) < MIN_PASSWORD_LENGTH) {
            return 'Минимальная длина пароля - ' . MIN_PASSWORD_LENGTH . ' символов';
        } elseif (preg_match('/[а-яё]/iu', $password)) {
            return 'Использование букв кириллицы в пароле не допускается';
        }

        return null;
    }

    /**
     * "Запомнить меня" - запись токена в БД
     * @param $login - логин пользователя
     * @param $password - пароль для создания md5
     */
    private
    function remember(
        string $login,
        string $password
    ): void {
        $password_token = md5($login . $password . time());

        $this::all()
            ->where('login', $login)
            ->first()
            ->update(['password_token' => $password_token]);

        setcookie('password_token', $password_token, time() + (30 * 24 * 60 * 60), '/');
    }

    /**
     * Удаляет токен для "запоминания" пользователя из БД
     * @param $login - логин пользователя, для которого удалить токен
     */
    private
    function removeToken(
        string $login
    ): void {
        $this::all()
            ->where('login', $login)
            ->first()
            ->update(['password_token' => null]);
    }

    /**
     * Сверяет логин и пароль
     * @return bool true - если пара верна, false - если не совпадает / не существует
     */
    private
    function verifyAuthData(): bool
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
    private
    function loginType(): string
    {
        return filter_var($_POST['username'], FILTER_VALIDATE_EMAIL) ? 'mail' : 'login';
    }
}

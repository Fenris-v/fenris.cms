<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * Class User - Singleton
 * @property mixed|string name
 * @property mixed|string mail
 * @property mixed|string about
 * @property mixed|string avatar
 * @property mixed|string password
 * @property int|mixed role_id
 * @property mixed|string login
 * @package App\Model
 */
final class User extends Model
{
    public static ?User $instance = null;
    public static ?string $role = null;
    protected $fillable = ['password_token', 'password', 'mail', 'role_id'];

    /**
     * Делаeт класс синглтоном
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
     * @param string $name
     * @return $this
     */
    public function setName(string $name): User
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @param string $mail
     * @return $this
     */
    public function setMail(string $mail): User
    {
        $this->mail = $mail;
        return $this;
    }

    /**
     * @param string $about
     * @return $this
     */
    public function setAbout(string $about): User
    {
        $this->about = $about;
        return $this;
    }

    /**
     * @param string $avatar
     * @return $this
     */
    public function setAvatar(string $avatar): User
    {
        $this->avatar = $avatar;
        return $this;
    }

    /**
     * @param int $id
     * @return $this
     */
    public function setRoleId(int $id): User
    {
        $this->role_id = $id;
        return $this;
    }

    /**
     * @param string $login
     * @return $this
     */
    public function setLogin(string $login): User
    {
        $this->login = $login;
        return $this;
    }

    /**
     * @param string $password
     * @return $this
     */
    public function setPassword(string $password): User
    {
        $this->password = $password;
        return $this;
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
     * Возвращает id текущего пользователя
     * @return int
     */
    public function getThisUserId(): int
    {
        return $this::all()
            ->where('login', $_SESSION['login'])
            ->first()
            ->id;
    }

    /**
     * Возвращает название роли
     * @param int $id
     * @return int
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

        return static::$role === 'manager';
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

        return static::$role === 'admin';
    }

    /**
     * Возвращает id роли пользователя
     * @return int
     */
    public function getRoleId(): int
    {
        return $this::all()->where('login', $_SESSION['login'])->first()->role_id ?? 0;
    }

    /**
     * Возвращает id роли пользователя по его id
     * @param int $id - id пользователя
     * @return int
     */
    public function getRoleByUserId(int $id): int
    {
        return $this::all()->where('id', $id)->first()->role_id ?? 0;
    }

    /**
     * Возвращает роль пользователя
     * @return string
     */
    private function getUserRole(): string
    {
        if (isset($_SESSION['login'])) {
            return (new Role())->getRoleName(
                $this::all()
                    ->where('login', $_SESSION['login'])
                    ->first()
                    ->role_id
            );
        }
        return 'guest';
    }
}

<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * Роли пользователей
 * Class Role
 * @package App\Model
 */
class Role extends Model
{
    /**
     * Возвращает название роли
     * @param $roleId - id роли
     * @return string
     */
    public function getRoleName($roleId): string
    {
        return $this::all()
            ->where('id', $roleId)
            ->first()
            ->role;
    }

    public function getRoleVisibleName($roleId): string
    {
        return $this::all()
            ->where('id', $roleId)
            ->first()
            ->name;
    }
}

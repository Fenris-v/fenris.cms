<?php

namespace App\Model;

class AdminPage extends Page
{
    /**
     * Возвращает страницы для меню админки с учетом роли
     * @return array
     */
    // TODO: просьба прокомментировать реализацию данного метода
    public function getPagesForRole(): array
    {
        $pages = [];
        foreach (Permission::all()->where('role_id', $_SESSION['role']) as $permission) {
            $pages[] = $permission->admin_page_id;
        }

        return $this::all()->whereIn('id', $pages)->toArray();
    }
}

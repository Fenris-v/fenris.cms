<?php

use App\Model\Role;
use App\Model\User;

$user = (new User());

if (!empty($_POST)) {
    $id = $user::all()->where('id', $data[1])->first()->id;
    $error = $user->setNewData($id);
}

$user = $user::all()->where('id', $data[1])->first();
?>

<div class="row">
    <form class="col-md-12" action="" method="post">
        <ul class="col-md-12 d-flex align-items-start flex-wrap">
            <li class="col-md-6">
                <div class="form-group">
                    <label for="name">Имя</label>
                    <input name="name"
                           type="text"
                           class="form-control"
                           id="name"
                           aria-describedby="emailHelp"
                           value="<?= $_POST['name'] ?? $user->name ?>">
                </div>
            </li>
            <li class="col-md-6">
                <div class="form-group">
                    <label for="login">Логин</label>
                    <input name="login"
                           type="text"
                           class="form-control"
                           id="login"
                           aria-describedby="emailHelp"
                           required
                           value="<?= $_POST['login'] ?? $user->login ?>">
                    <span class="text-danger"><?= isset($error['login']) ? $error['login'] : '' ?></span>
                </div>
            </li>
            <li class="col-md-6">
                <div class="form-group">
                    <label for="mail">Email</label>
                    <input name="mail"
                           type="email"
                           class="form-control"
                           id="mail"
                           aria-describedby="emailHelp"
                           required
                           value="<?= $_POST['mail'] ?? $user->mail ?>">
                    <span class="text-danger"><?= isset($error['mail']) ? $error['mail'] : '' ?></span>
                </div>
            </li>
            <li class="col-md-6">
                <div class="form-group">
                    <label for="role">Роль</label>
                    <select required class="form-control" name="role" id="role">
                        <?php
//                        $userRole = trim($_POST['role']) ?? $user->role_id;
                        foreach (Role::all() as $role): ?>
                            <option value="<?= $role->id ?>" <?=
                            (int) $_SESSION['role'] === (int) $role->id ? 'selected' : ''
                            ?>><?= $role->name ?></option>
                        <?php
                        endforeach; ?>
                    </select>
                </div>
            </li>
            <li class="col-md-6">
                <div class="form-group">
                    <input type="checkbox"
                           name="subscribe"
                           id="subscribe"
                        <?php
                        if (isset($_POST['subscribe'])): ?>
                            checked
                        <?php
                        elseif (!isset($_POST) && (bool)$user->subscribe): ?>
                            checked
                        <?php
                        endif; ?>>
                    <label for="subscribe">Подписан на рассылку</label>
                </div>
            </li>
            <li class="col-md-6">
                <div class="form-group">
                    <input class="btn btn-primary"
                           type="submit"
                           id="save"
                           value="Сохранить">
                </div>
            </li>
        </ul>
    </form>
</div>

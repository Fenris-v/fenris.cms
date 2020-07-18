<?php

use App\Controller\UserController;
use App\Exception\DataException;
use App\Exception\SaveException;
use App\Model\Role;
use App\Model\User;

if (!empty($_POST)) {
    try {
        (new UserController())->setNewData($data[0]);
    } catch (DataException $exception) {
    } catch (SaveException $exception) { ?>
        <span class="text-danger"><?= $exception->getMessage() ?></span>
        <?php
    }
}

$user = User::all()->where('id', $data[0])->first();
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
                           value="<?= $_POST['name'] ?? $user->name ?>">
                </div>
            </li>
            <li class="col-md-6">
                <div class="form-group">
                    <label for="username">Логин</label>
                    <input name="username"
                           type="text"
                           class="form-control"
                           id="username"
                           required
                           value="<?= $_POST['login'] ?? $user->login ?>">
                    <span class="text-danger"><?= DataException::$errors['login'] ?? '' ?></span>
                </div>
            </li>
            <li class="col-md-6">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input name="email"
                           type="email"
                           class="form-control"
                           id="email"
                           required
                           value="<?= $_POST['mail'] ?? $user->mail ?>">
                    <span class="text-danger"><?= DataException::$errors['mail'] ?? '' ?></span>
                </div>
            </li>
            <li class="col-md-6">
                <div class="form-group">
                    <label for="role">Роль</label>
                    <select required class="form-control" name="role" id="role">
                        <?php
                        foreach (Role::all() as $role): ?>
                            <option value="<?= $role->id ?>" <?=
                            (int)$_SESSION['role'] === (int)$role->id ? 'selected' : ''
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
                           class="checkbox"
                           id="subscribe"
                        <?php
                        if ((bool)$user->subscribe): ?>
                            checked
                        <?php
                        endif; ?>>
                    <label class="checkbox" for="subscribe">Подписан на рассылку</label>
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

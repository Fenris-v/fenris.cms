<?php

use App\Controller\UserController;
use App\Exception\DataException;
use App\Exception\SaveException;
use App\Model\User;

if (!empty($_POST)) {
    if (isset($_POST['upload'])) {
        try {
            /** @noinspection PhpUndefinedVariableInspection */
            (new UserController())->uploadAvatar($param[array_key_last($param)]);
        } catch (DataException $exception) {
        } catch (SaveException $exception) { ?>
            <span class="text-danger"><?= $exception->getMessage() . ' - ' . $exception->getCode() ?></span>
            <?php
        }
    } elseif (isset($_POST['remove'])) {
        try {
            /** @noinspection PhpUndefinedVariableInspection */
            (new UserController())->removeAvatar($param[array_key_last($param)]);
        } catch (SaveException $exception) { ?>
            <span class="text-danger"><?= $exception->getMessage() . ' - ' . $exception->getCode() ?></span>
            <?php
        }
    } else {
        try {
            /** @noinspection PhpUndefinedVariableInspection */
            (new UserController)->minEdit($param[array_key_last($param)]);
        } catch (DataException $exception) {
        } catch (SaveException $exception) { ?>
            <span class="text-danger"><?= $exception->getMessage() . ' - ' . $exception->getCode() ?></span>
            <?php
        }
    }
}

if ($_SESSION['login'] !== $param[array_key_last($param)]) {
    redirectOnPage('/lk/' . $_SESSION['login']);
}

$user = User::all()->where('login', $param[array_key_last($param)])->first();

try {
    /** @noinspection PhpUndefinedVariableInspection */
    includeView('layout.header', ['title' => $title]);
} catch (Exception $exception) {
    echo $exception->getMessage() . ' ' . $exception->getCode();
} ?>

    <section class="pt-5 s_profile">
        <div class="row container">
            <div class="profile col-md-8">
                <form class="col-md-12" action="" method="post">
                    <ul class="col-md-12 d-flex align-items-start flex-wrap">
                        <li class="col-md-12">
                            <div class="form-group">
                                <label for="name">Имя</label>
                                <input name="name"
                                       type="text"
                                       class="form-control"
                                       id="name"
                                       required
                                       value="<?= $user->name ?? '' ?>">
                            </div>
                        </li>
                        <li class="col-md-12">
                            <div class="form-group">
                                <label for="mail">Email</label>
                                <input name="mail"
                                       type="email"
                                       class="form-control"
                                       id="mail"
                                       value="<?= $user->mail ?>">
                                <span class="text-danger"><?= isset(DataException::$errors['mail'])
                                        ? DataException::$errors['mail']
                                        : '' ?></span>
                            </div>
                        </li>
                        <li class="col-md-12">
                            <div class="form-group">
                                <label for="aboutUser">О себе</label>
                                <textarea name="aboutUser"
                                          class="form-control"
                                          rows="3"
                                          id="aboutUser"><?= $user->about ?? '' ?></textarea>
                            </div>
                        </li>
                        <li class="col-md-12">
                            <div class="form-group">
                                <input class="btn btn-primary"
                                       type="submit"
                                       value="Сохранить">
                            </div>
                        </li>
                    </ul>
                </form>
            </div>
            <div class="col-md-4 d-flex justify-content-center align-items-start">
                <form enctype="multipart/form-data"
                      class="col-md-12 d-flex justify-content-center flex-column align-items-center" action=""
                      method="post">
                    <img class="rounded-circle mb-3 avatar"
                         src="<?= $user->avatar ? $user->avatar : '/templates/images/logo.jpeg' ?>"
                         alt="user">
                    <?php
                    if (!$user->avatar): ?>
                        <input name="image"
                               type="file"
                               class="form-control-file mb-3 avatarUpload"
                               id="image"
                               accept="image/png, image/jpeg, image/jpg, image/gif"
                               required>
                        <span class="text-danger"><?= isset(DataException::$errors['image'])
                                ? DataException::$errors['image']
                                : '' ?></span>
                    <?php
                    endif; ?>
                    <div class="form-group mb-3">
                        <input class="btn btn-primary"
                               name="<?= $user->avatar ? 'remove' : 'upload' ?>"
                               type="submit"
                               value="<?= $user->avatar ? 'Удалить' : 'Загрузить' ?>">
                    </div>
                </form>
            </div>
        </div>
    </section>

<?php
try {
    includeView('layout.footer');
} catch (Exception $exception) {
    echo $exception->getMessage() . ' ' . $exception->getCode();
}

<?php

use App\Controller\UserController;
use App\Exception\DataException;

if (isset($_POST['new_code']) && $_POST['new_code'] === '') {
    (new UserController)->newCode();
    redirectOnPage($_SERVER['REQUEST_URI']);
} elseif (!empty($_POST) && empty($param)) {
    unset($_SESSION['password_reset']);
    try {
        (new UserController)->auth();
    } catch (DataException $exception) {
    }
} elseif (isset($_POST['new_password'])) {
    $success = (new UserController())->resetPassword();
} elseif (
    isset($_POST['forget_submit']) && !isset($_SESSION['secret_code_time']) && !isset($success) ||
    isset($_POST['forget_submit']) && isset($_SESSION['secret_code_time']) && !isSessionLive() && !isset($success)
) {
    try {
        (new UserController)->forgetPassword();
    } catch (DataException $exception) { ?>
        <?php
    }
}

if (isset($_SESSION['secret_code']) && isset($_POST['secret'])) {
    $isCheckCode = $_SESSION['secret_code'] === $_POST['secret'];
}

/** Редирект, если авторизованный пользователь попытается зайти на страницу авторизации */
if (isset($_SESSION['login']) && isset($_SESSION['role']) && $_SESSION['role'] !== 0) {
    redirectOnPage();
}

try {
    /** @noinspection PhpUndefinedVariableInspection */
    includeView('layout.head', ['title' => $title]);
} catch (Exception $exception) {
    echo $exception->getMessage() . ' ' . $exception->getCode();
} ?>

<div class="auth-bg">
    <img id="auth-bg" src="/templates/images/bg.jpg" alt="background">
    <img id="sun" src="/templates/images/sun.png" alt="sun">
</div>

<form class="form-signin m-auto p-4" method="post">
    <img class="mb-4" src="/templates/images/logo.jpeg" alt="logo">
    <h1 class="h3 mb-3 font-weight-normal text-center">
        <?= isset($param[0]) ? 'Сброс пароля' : 'Пожалуйста авторизуйтесь' ?>
    </h1>
    <?php
    if (empty($param)): ?>
        <span class="text-success">
            <?= isset($_SESSION['password_reset']) ? 'Пароль сброшен' : '' ?>
        </span>
        <span class="text-danger"><?= DataException::$errors['auth'] ?? '' ?></span>
        <label for="inputEmail" class="sr-only">Email или логин</label>
        <input name="username" type="text" id="inputEmail" class="form-control mb-2" placeholder="Email или логин"
               required="" autofocus="" value="<?= $_POST['username'] ?? '' ?>">
        <label for="inputPassword" class="sr-only">Пароль</label>
        <input name="password" type="password" id="inputPassword" class="form-control mb-2" placeholder="Пароль"
               required="" value="<?= $_POST['password'] ?? '' ?>">
        <div class="checkbox mb-3">
            <label>
                <input name="remember" type="checkbox" value="remember-me"> Запомнить меня
            </label>
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Авторизоваться</button>
        <!--suppress HtmlUnknownTarget -->
        <a href="/auth/forget" class="signLink">Забыли пароль?</a>
    <?php
    elseif (isset($isCheckCode) && $isCheckCode): ?>
        <label for="newPassword" class="sr-only">Новый пароль</label>
        <input name="new_password" type="password" id="newPassword" class="form-control" placeholder="Новый пароль"
               required="" autofocus="">
        <span class="text-danger"><?= $success ?? '' ?></span>
        <button name="reset" class="btn btn-lg btn-primary btn-block mt-2" type="submit">Сбросить</button>
        <!--suppress HtmlUnknownTarget -->
        <a href="/auth" class="signLink">Авторизоваться</a>  <?php
    elseif (isset($param[0]) && isset($_SESSION['secret_code']) && isSessionLive()) : ?>
        <label for="secret" class="sr-only">Код из письма</label>
        <input name="secret" type="text" id="secret" class="form-control" placeholder="Код из письма"
               autofocus="">
        <span class="text-danger"><?= DataException::$errors['code'] ?? '' ?></span>
        <button name="reset" class="btn btn-lg btn-primary btn-block mt-2" type="submit">Сбросить</button>
        <button name="new_code" class="btn btn-lg btn-secondary btn-block mt-2" type="submit">Новый код</button>
        <!--suppress HtmlUnknownTarget -->
        <a href="/auth" class="signLink">Авторизоваться</a> <?php
    elseif (isset($param[0])): ?>
        <label for="inputEmail" class="sr-only">Email или логин</label>
        <input name="username" type="text" id="inputEmail" class="form-control mb-2" placeholder="Email или логин"
               required="" autofocus="" value="<?= $_POST['username'] ?? '' ?>">
        <span class="text-danger"><?= isset($exception) ? $exception->getMessage() : '' ?></span>
        <button name="forget_submit" class="btn btn-lg btn-primary btn-block" type="submit">Сбросить</button>
        <!--suppress HtmlUnknownTarget -->
        <a href="/auth" class="signLink">Авторизоваться</a>
    <?php
    endif ?>
    <!--suppress HtmlUnknownTarget -->
    <a href="/registration" class="signLink">Зарегистрироваться</a>
    <a href="/" class="signLink">Вернуться на главную</a>
</form>

<script src="/templates/js/jquery-3.5.1.min.js"></script>
<script src="/templates/js/popper.min.js"></script>
<script src="/templates/js/bootstrap.min.js"></script>
<script src="/templates/js/gsap.min.js"></script>
<script src="/templates/js/authAmimate.js"></script>

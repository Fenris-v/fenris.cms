<?php

use App\Controller\UserController;
use App\Exception\DataException;

if (isset($_POST['new_code'])) {
    (new UserController())->newCode();
    redirectOnPage($_SERVER['REQUEST_URI']);
} elseif (isset($_POST['secret'])) {
    try {
        (new UserController())->checkCode();
    } catch (DataException $exception) {
    }
} elseif (isset($_POST['email']) && isset($_POST['password']) && isset($_POST['username'])) {
    try {
        (new UserController())->registration();
    } catch (DataException $exception) {
    }
}

try {
    /** @noinspection PhpUndefinedVariableInspection */
    includeView('layout.head', ['title' => $title]);
} catch (Exception $e) {
    echo $exception->getMessage() . ' ' . $exception->getCode();
} ?>

<div class="auth-bg">
    <img id="auth-bg" src="/templates/images/bg.jpg" alt="background">
    <img id="sun" src="/templates/images/sun.png" alt="sun">
</div>

<form class="form-signin m-auto p-4" method="post">
    <img class="mb-4" src="/templates/images/logo.jpeg" alt="logo">
    <h1 class="h3 mb-3 font-weight-normal">Зарегистрироваться</h1>
    <?php
    if (isset($_SESSION['final_reg']) && $_SESSION['final_reg'] === 'success'): ?>
        <p>Пользователь успешно создан! Вы будете автоматически перенаправлены на главную страницу через 5 секунд.</p>
    <?php
    elseif (
        isset($_SESSION['secret_code']) &&
        isset($_SESSION['secret_code_time']) &&
        $_SESSION['secret_code'] &&
        isSessionLive()
    ): ?>
        <label for="secret" class="sr-only">Код из письма</label>
        <input name="secret" type="text" id="secret" class="form-control" placeholder="Код из письма"
               autofocus="">
        <span class="text-danger"><?= DataException::$errors['code'] ?? '' ?></span>
        <button class="btn btn-lg btn-primary btn-block mt-2" type="submit">Подтвердить</button>
        <button name="new_code" class="btn btn-lg btn-secondary btn-block mt-2" type="submit">Новый код</button>
    <?php
    else: ?>
        <label for="inputEmail" class="sr-only">Email</label>
        <input name="email" type="email" id="inputEmail" class="form-control" placeholder="Email" required=""
               autofocus="" value="<?= $_POST['email'] ?? '' ?>">
        <span class="text-danger"><?= DataException::$errors['mail'] ?? '' ?></span>
        <label for="inputPassword" class="sr-only">Логин</label>
        <input name="username" type="text" id="inputLogin" class="form-control mt-2" placeholder="Логин" required=""
               value="<?= $_POST['username'] ?? '' ?>">
        <span class="text-danger"><?= DataException::$errors['login'] ?? '' ?></span>
        <label for="inputLogin" class="sr-only">Пароль</label>
        <input name="password" type="password" id="inputPassword" class="form-control mt-2" placeholder="Пароль"
               required="" value="<?= $_POST['password'] ?? '' ?>">
        <span class="text-danger"><?= DataException::$errors['password'] ?? '' ?></span>
        <button class="btn btn-lg btn-primary btn-block mt-2" type="submit">Зарегистрироваться</button>
        <!--suppress HtmlUnknownTarget -->
        <a href="/auth" class="signLink">Авторизоваться</a>
    <?php
    endif; ?>
    <a href="/" class="signLink">Вернуться на главную</a>
</form>

<script src="/templates/js/jquery-3.5.1.min.js"></script>
<script src="/templates/js/popper.min.js"></script>
<script src="/templates/js/bootstrap.min.js"></script>
<script src="/templates/js/gsap.min.js"></script>
<script src="/templates/js/authAmimate.js"></script>

<?php
if (isset($_SESSION['final_reg']) && $_SESSION['final_reg'] === 'success'):
    unset($_SESSION['final_reg']); ?>
    <script>
        $(document).ready(() => {
            setTimeout(
                () => {
                    document.location.href = '/'
                }, 5000);
        });
    </script>
<?php
endif; ?>

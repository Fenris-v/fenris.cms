<?php

use App\Controller\SubscribeController;
use App\Exception\DataException;
use App\Exception\SaveException;
use App\Model\Subscribe;
use App\Model\User;


if (isset($_GET['unsubscribe'])) {
    try {
        (new SubscribeController())->unsubscribe();
    } catch (SaveException $exception) { ?>
        <span class="text-danger"><?= $exception->getMessage() . ' - ' . $exception->getCode() ?></span>
        <?php
    }
} ?>

<header>
    <div class="container">
        <div class="header row flex-nowrap justify-content-between align-items-center">
            <div class="col-4 pt-1">
                <form method="post">
                    <?php
                    if (isset($_POST['subscribe']) || isset($_POST['unsubscribe'])) {
                        try {
                            (new SubscribeController())->changeSubscribe();
                        } catch (SaveException $exception) { ?>
                            <span class="text-danger"><?=
                                $exception->getMessage() . ' - ' . $exception->getCode()
                                ?></span>
                            <?php
                        } catch (DataException $exception) { ?>
                            <span class="text-danger"><?= DataException::$errors['mail'] ?></span>
                            <?php
                        }
                    }

                    if (isset($_SESSION['login']) && !isset($_SESSION['secret_code'])):
                        $user = User::all()->where('login', $_SESSION['login'])->first();
                        $userMail = $user->mail;
                        $isSubscribe = Subscribe::all()
                                ->where('mail', $userMail)
                                ->first() !== null ?>
                        <input type="submit"
                               name="<?= $isSubscribe ? 'unsubscribe' : 'subscribe' ?>"
                               value="<?= $isSubscribe ? 'Отписаться' : 'Подписаться' ?>"
                               class="btn btn-primary">
                    <?php
                    else: ?>
                        <div class="d-flex">
                            <!--suppress HtmlFormInputWithoutLabel -->
                            <input class="form-control topSubscribe"
                                   name="mail"
                                   type="email"
                                   placeholder="Введите email">
                            <input type="submit"
                                   name="subscribe"
                                   value="Подписаться"
                                   class="btn btn-primary">
                        </div>
                    <?php
                    endif; ?>
                </form>
            </div>
            <div class="col-4 text-center">
                <a id="headerLogo" class="blog-header-logo d-flex justify-content-center align-items-center" href="/">
                    <img src="/templates/images/logo.jpeg" alt="logo">
                    <p>Fenris blog</p>
                </a>
            </div>
            <div class="col-4 d-flex justify-content-end align-items-center">
                <?php
                if (isset($_SESSION['login']) && $_SESSION['login'] && isset($_SESSION['role']) && !isset($_SESSION['secret_code'])): ?>
                    <a href="/lk/<?= $_SESSION['login'] ?>" class="userLink mr-5 d-flex align-items-center">
                        <i class="fas fa-user mr-2"></i>
                        <p>Привет, <?= trim(User::getInstance()->getName()); ?>!</p>
                    </a>
                <?php
                endif; ?>

                <a class="btn btn-primary"
                   href="<?= isset($_SESSION['login']) && isset($_SESSION['role']) && !isset($_SESSION['secret_code'])
                       ? '?logout' : '/auth' ?>">
                    <?= isset($_SESSION['login']) && isset($_SESSION['role']) && !isset($_SESSION['secret_code'])
                        ? 'Выйти' : 'Войти' ?>
                </a>
            </div>
        </div>

        <div class="nav-scroller">
            <?php
            try {
                includeView('render.headerCategories');
            } catch (Exception $exception) {
                echo $exception->getMessage() . ' ' . $exception->getCode();
            }
            ?>
        </div>
    </div>
</header>

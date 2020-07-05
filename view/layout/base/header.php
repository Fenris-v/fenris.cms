<header>
    <div class="container">
        <div class="header row flex-nowrap justify-content-between align-items-center">
            <div class="col-4 pt-1">
                <?php

                use App\Model\User;

                if (isset($_POST['subscribe']) || isset($_POST['unsubscribe'])) {
                    (new User())->changeSubscribe();
                }

                if (isset($_SESSION['login'])):
                    $isSubscribe = (bool)User::all()
                        ->where('login', $_SESSION['login'])
                        ->first()
                        ->subscribe; ?>
                    <form method="post">
                        <input type="submit"
                               name="<?= $isSubscribe ? 'unsubscribe' : 'subscribe' ?>"
                               value="<?= $isSubscribe ? 'Отписаться' : 'Подписаться' ?>"
                               class="btn btn-primary">
                    </form>
                <?php
                endif; ?>
            </div>
            <div class="col-4 text-center">
                <a id="headerLogo" class="blog-header-logo d-flex justify-content-center align-items-center" href="/">
                    <img src="/templates/images/logo.jpeg" alt="logo">
                    <p>Fenris blog</p>
                </a>
            </div>
            <div class="col-4 d-flex justify-content-end align-items-center">
                <?php
                if (isset($_SESSION['login']) && $_SESSION['login'] && isset($_SESSION['role'])): ?>
                    <a href="/lk/<?= $_SESSION['login'] ?>" class="userLink mr-5 d-flex align-items-center">
                        <i class="fas fa-user mr-2"></i>
                        <p>Привет, <?= trim(User::getInstance()->getName()); ?>!</p>
                    </a>
                <?php
                endif; ?>

                <a class="btn btn-primary"
                   href="<?= isset($_SESSION['login']) && isset($_SESSION['role']) ? '?logout' : '/auth' ?>">
                    <?= isset($_SESSION['login']) && isset($_SESSION['role']) ? 'Выйти' : 'Войти' ?>
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

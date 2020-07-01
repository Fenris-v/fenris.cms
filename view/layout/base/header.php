<header>
    <div class="container">
        <div class="header row flex-nowrap justify-content-between align-items-center">
            <div class="col-4 pt-1">
                <?php

                use App\Model\User;

                if (isset($_SESSION['login'])): ?>
                    <a class="btn btn-primary" href="#">Подписаться</a>
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
                    <a href="#" class="userLink mr-5 d-flex align-items-center">
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

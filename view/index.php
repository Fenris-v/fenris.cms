<?php

try {
    /** @noinspection PhpUndefinedVariableInspection */
    includeView('layout.header', ['title' => $title]);
} catch (Exception $exception) {
    echo $exception->getMessage() . ' ' . $exception->getCode();
} ?>

    <section class="s_lastPublications pt-5">
        <div class="container">
            <?php
            try {
                includeView('render.articleTop');
            } catch (Exception $exception) {
                echo $exception->getMessage() . ' ' . $exception->getCode();
            } ?>
        </div>
    </section>

    <section class="s_list mb-5">
        <div class="container">
            <div class="row">
                <div class="col-md-12 blog-main">
                    <?php
                    try {
                        includeView('render.articleList', ['page' => $page ?? '']);
                    } catch (Exception $exception) {
                        echo $exception->getMessage() . ' ' . $exception->getCode();
                    }
                    ?>
                </div>
            </div>
        </div>
    </section>

<?php
try {
    includeView('layout.footer');
} catch (Exception $exception) {
    echo $exception->getMessage() . ' ' . $exception->getCode();
}

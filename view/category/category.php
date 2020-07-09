<?php

use App\Model\Category;

/** @noinspection PhpUndefinedVariableInspection */
if (Category::all()->where('uri', $param[0])->first() === null):
    try {
        includeView('layout.header', ['title' => 'Несуществующая категория']);
    } catch (Exception $exception) {
        echo $exception->getMessage() . ' ' . $exception->getCode();
    }
    ?>
    <h2 class="h2 text-danger">Категории с таким адресом не существует!</h2>
<?php
else:
    try {
        /** @noinspection PhpUndefinedVariableInspection */
        includeView('layout.header', ['title' => $title, 'description' => $metaDescription]);
    } catch (Exception $exception) {
        echo $exception->getMessage() . ' ' . $exception->getCode();
    } ?>

    <section class="s_lastPublications pt-5">
        <div class="container">
            <?php
            try {
                includeView('render.articleTop', $param);
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
                        includeView('render.articleList', [$param[0]]);
                    } catch (Exception $exception) {
                        echo $exception->getMessage() . ' ' . $exception->getCode();
                    }
                    ?>
                </div>
            </div>
        </div>
    </section>
<?php
endif;

try {
    includeView('layout.footer');
} catch (Exception $exception) {
    echo $exception->getMessage() . ' ' . $exception->getCode();
}

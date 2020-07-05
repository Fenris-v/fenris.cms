<?php

use App\Model\Article;
use App\Model\Category;
use App\Model\User;

/** @noinspection PhpUndefinedVariableInspection */
$article = Article::all()->where('uri', $param[array_key_last($param)])->first();

try {
    /** @noinspection PhpUndefinedVariableInspection */
    includeView('layout.header', ['title' => $title, 'description' => $metaDescription]);
} catch (Exception $exception) {
    echo $exception->getMessage() . ' ' . $exception->getCode();
} ?>

    <section class="s_breadcrumb">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb align-items-center mb-0">
                    <li class="breadcrumb-item"><a href="/">Главная</a></li>
                    <?php
                    $link = '';
                    for ($i = 0; $i < count($param); $i++):
                        $link .= '/' . $param[$i]; ?>
                        <?php
                        if ($i !== array_key_last($param)) : ?>
                            <li class="breadcrumb-item d-flex align-items-center">
                                <a href="<?= $link ?>"><?=
                                    Category::all()
                                        ->where('uri', $param[$i])
                                        ->first()
                                        ->name
                                    ?></a>
                            </li>
                        <?php
                        else: ?>
                            <li class="breadcrumb-item active"
                                aria-current="page">
                                <?= $article->title ?>
                            </li>
                        <?php
                        endif;
                    endfor; ?>
                </ol>
            </nav>
        </div>
    </section>

    <section class="s_article">
        <div class="container">
            <div class="article">
                <h1 class="h2"><?= $title ?></h1>
                <p class="blog-post-meta mb-3"><?= $article->created_at ?> by
                    <a class="badge badge-primary" href="#"><?= mb_ucfirst(
                            User::all()
                                ->where('id', $article->author_id)
                                ->first()
                                ->login
                        ) ?></a>
                </p>

                <img class="float-right" style="max-width: 400px;" src="<?= $article->image ?>" alt="image">
                <?= $article->text ?>
            </div>
        </div>
    </section>

<?php
try {
    includeView('layout.footer');
} catch (Exception $exception) {
    echo $exception->getMessage() . ' ' . $exception->getCode();
}

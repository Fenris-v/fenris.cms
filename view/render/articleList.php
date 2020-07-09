<?php

use App\Model\Article;
use App\Model\Category;
use App\Model\Config;
use App\Model\User;

$categoryId = isset($data[0]) ? Category::all()->where('uri', $data[0])->first()->id : '';

$articlesCount = $categoryId
    ? Article::all()->where('category_id', $categoryId)->count()
    : Article::all()->count();

$perPage = Config::all()->where('name', 'per_page')->first()->val;
if ($perPage === 'all' || !$perPage) {
    $articles = $categoryId
        ? Article::all()->where('category_id', $categoryId)->sortByDesc('created_at')
        : Article::all()->sortByDesc('created_at');
} else {
    if (!isset($data['page'][0])) {
        $articles = $categoryId
            ? Article::all()->where('category_id', $categoryId)->sortByDesc('created_at')->forPage(1, (int)$perPage)
            : Article::all()->sortByDesc('created_at')->forPage(1, (int)$perPage);
    } else {
        $articles = $categoryId
            ? Article::all()->where('category_id', $categoryId)->sortByDesc('created_at')->forPage((int)$data['page'][0], (int)$perPage)
            : Article::all()->sortByDesc('created_at')->forPage((int)$data['page'][0], (int)$perPage);
    }
}

if (!empty($articles->all())):
    foreach ($articles->all() as $article): ?>
        <div class="blog-post col-md-12 row">
            <div class="col-md-10">
                <h2 class="blog-post-title"><?= $article->getOriginal('title') ?></h2>
                <p class="blog-post-meta mb-3"><?= $article->getOriginal('created_at') ?> by
                    <a class="badge badge-primary" href="#"><?=
                        mb_ucfirst(
                            User::all()
                                ->where('id', $article->getOriginal('author_id'))
                                ->first()
                                ->login
                        ) ?></a>
                </p>

                <?= $article->getOriginal('short_desc') ?>

                <a href="/<?=
                Category::all()
                    ->where('id', $article->getOriginal('category_id'))
                    ->first()->uri . '/' .
                $article->getOriginal('uri') ?>" class="btn btn-primary mt-3">Читать больше</a>
            </div>
            <div class="col-md-2">
                <img class="img-thumbnail" src="<?= $article->getOriginal('image') ?>" alt="image">
            </div>
        </div>
    <?php
    endforeach;
    $page = $page[0] ?? 1; ?>
    <nav class="blog-pagination">
        <a class="btn <?= $page > 1 ? 'btn-outline-primary' : 'btn-outline-secondary disabled' ?>"
           href="/page/<?= $page > 1 ? $page - 1 : '1' ?>">Предыдущие</a>
        <a class="btn <?= $articlesCount / $perPage > $page ? 'btn-outline-primary' : 'btn-outline-secondary disabled' ?>"
           href="/page/<?= $page + 1 ?>"
           aria-disabled="true">Следующие</a>
    </nav>
<?php
else: ?>
    <h2 class="h2">Категория пуста <span class="cyber">:(</span></h2>
<?php
endif;

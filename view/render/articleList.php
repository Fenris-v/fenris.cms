<?php

use App\Model\Article;
use App\Model\Category;
use App\Model\User;

$categoryId = isset($data[0]) ? Category::all()->where('uri', $data[0])->first()->id : '';
$articles = $categoryId ? Article::all()->where('category_id', $categoryId) : Article::all();

if (!empty($articles->all())):
    foreach ($articles->all() as $article):?>
        <div class="blog-post col-md-12 row">
            <div class="col-md-8">
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

                <a href="<?=
                Category::all()
                    ->where('id', $article->getOriginal('category_id'))
                    ->first()->uri . '/' .
                $article->getOriginal('uri') ?>" class="btn btn-primary mt-3">Читать больше</a>
            </div>
            <div class="col-md-4">
                <img class="img-thumbnail" src="<?= $article->getOriginal('image') ?>" alt="image">
            </div>
        </div>
    <?php
    endforeach;
else: ?>
    <h2 class="h2">Категория пуста <span class="cyber">:(</span></h2>
<?php
endif;

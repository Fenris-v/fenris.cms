<?php

use App\Model\Article;

foreach (Article::all() as $article):
    $articleData = $article->attributesToArray(); ?>

    <div class="blog-post">
        <h2 class="blog-post-title cyber"><?= $articleData['title'] ?></h2>
        <p class="blog-post-meta mb-3"><?= $articleData['date'] ?> by
            <a class="badge badge-primary" href="#">Mark</a>
        </p>

        <?= $articleData['short_desc'] ?>

        <hr>

        <?= $articleData['text'] ?>

        <a href="<?= $articleData['uri'] ?>" class="btn btn-primary mt-3">Читать больше</a>
    </div>

<?php
endforeach;

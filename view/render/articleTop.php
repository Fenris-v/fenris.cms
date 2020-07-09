<?php

use App\Model\Article;
use App\Model\Category;

if (isset($data[0])) {
    $category = Category::all()->where('uri', $data[0])->first();
    $articles = Article::all()
        ->where('top', 1)
        ->where('category_id', $category->id)
        ->take(2);
} else {
    $articles = Article::all()->where('top', 1)->take(2);
    $categories = (new Category())::all();
} ?>

<div class="lastPublications row mb-2">
    <?php
    foreach ($articles as $article): ?>
        <div class="col-md-6">
            <div class="topPosts row no-gutters border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
                <div class="col-md-8 col p-4 d-flex flex-column position-static bg-yellow">
                    <strong class="d-inline-block mb-2 text-primary"><?= isset($category) ? $category->name : $categories
                            ->where('id', $article->category_id)
                            ->first()
                            ->name ?></strong>
                    <h3 class="mb-0"><?= cutStr($article->title) ?></h3>
                    <div class="mb-1 text-muted"><?= $article->created_at ?></div>
                    <p class=""><?= cutStr($article->short_desc, 105) ?></p>
                    <a href="<?= isset($category) ? $_SERVER['REQUEST_URI'] . '/' . $article->uri : '/' . $categories
                        ->where('id', $article->category_id)
                        ->first()
                        ->uri . '/' . $article->uri ?>" class="stretched-link">Продолжить читать</a>
                </div>
                <div class="col-md-4 col-auto d-none d-lg-block">
                    <img class="topArticleImage" src="<?= $article->image ?>" alt="image">
                </div>
            </div>
        </div>
    <?php
    endforeach; ?>
</div>

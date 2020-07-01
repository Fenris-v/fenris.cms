<?php

use App\Model\Category;

$categories = Category::all(); ?>

<nav class="nav d-flex justify-content-center">
    <?php
    foreach ($categories as $category):
        $categoryData = $category->attributesToArray(); ?>
        <a class="p-2" href="<?= $category['uri'] ?>">
            <?= $category['name'] ?>
        </a>
    <?php
    endforeach; ?>
</nav>

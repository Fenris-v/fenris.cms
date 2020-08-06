<?php

use App\Controller\ConfigController;
use App\Model\Article;
use App\Model\Category;

if (isset($data) && $data[0] === 'list') {
    redirectOnPage($_SERVER['REQUEST_URI'] . '/' . Category::all()->first()->uri);
}

if (isset($_POST['per_page'])) {
    (new ConfigController())->setPageSize();
}

$categories = Category::all();

$category = $categories->where('uri', $data[0])->first();
if ($category !== null) {
    $categoryName = $category->name;
    $categoryId = $category->id;

    $articles = Article::all()->where('category_id', $categoryId);

    ?>
    <div class="d-flex mb-3 align-items-start">
        <!--suppress HtmlUnknownTarget -->
        <a class="btn btn-primary text-white mr-3" href="/admin/articles/new/article"><i
                    class="fas fa-plus-circle mr-2"></i>Добавить статью</a>
        <!--suppress HtmlUnknownTarget -->
        <a class="btn btn-primary text-white mr-3" href="/admin/articles/new/category"><i
                    class="fas fa-plus-circle mr-2"></i>Добавить категорию</a>
        <form method="post" class="ml-auto">
                <label for="perPage">Количество статей на странице</label>
                <select name="per_page" id="perPage" class="form-control mb-2">
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="50">50</option>
                    <option value="200">200</option>
                    <option value="all">Все</option>
                </select>
            <input type="submit" class="btn btn-primary" value="Применить">
        </form>
    </div>
    <div>
        <h1 class="h2">Категории</h1>
        <ul class="categoryList d-flex flex-wrap">
            <?php
            foreach ($categories as $category): ?>
                <li class="mr-3">
                    <a class="btn <?=
                    $category->uri === $data[0] ? 'btn-primary' : 'btn-secondary';
                    ?>" href="/admin/articles/list/<?= $category->uri ?>"><?= $category->name ?></a>
                </li>
            <?php
            endforeach; ?>
        </ul>
    </div>

    <div>
        <h2 class="h2">Статьи</h2>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th scope="col">Категория</th>
                <th scope="col">Название</th>
                <th scope="col">Адрес</th>
                <th scope="col">Дата публикации</th>
                <th scope="col">Дата изменения</th>
                <th scope="col">Изменить</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td><?= $categoryName ?></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td><a href="/admin/articles/category/edit/<?= $categoryId ?>">Изменить</a></td>
            </tr>
            <?php
            foreach ($articles as $article): ?>
                <tr>
                    <td></td>
                    <td><?= $article->title ?></td>
                    <td><?= $article->uri ?></td>
                    <td><?= $article->created_at ?></td>
                    <td><?= $article->updated_at ?></td>
                    <td><a href="/admin/articles/article/edit/<?= $article->id ?>">Изменить</a></td>
                </tr>
            <?php
            endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php
} else { ?>
    <h2 class="h2 text-danger">Такой категории не существует, проверьте адрес</h2>
    <?php
}

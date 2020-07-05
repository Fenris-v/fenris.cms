<?php

use App\Model\Article;
use App\Model\Category;

if (!empty($_POST)) {
    $article = new Article();
    $error = $article->addArticle();

    if (isset($error['success']) && $error['success'] === 'yes') {
        redirectOnPage('/admin/articles');
    }
} ?>

<div class="row">
    <form class="col-md-12" action="" method="post" enctype="multipart/form-data">
        <ul class="col-md-12 d-flex align-items-start flex-wrap">
            <li class="col-md-6">
                <div class="form-group">
                    <label for="name">Заголовок статьи</label>
                    <input name="name"
                           type="text"
                           class="form-control"
                           id="name"
                           required
                           value="<?= $_POST['name'] ?? '' ?>">
                    <span class="text-danger"><?= isset($error['title']) ? $error['title'] : '' ?></span>
                </div>
            </li>
            <li class="col-md-6">
                <div class="form-group">
                    <label for="alias">Адрес статьи</label>
                    <input name="alias"
                           type="text"
                           class="form-control"
                           id="alias"
                           value="<?= $_POST['alias'] ?? '' ?>">
                    <small class="form-text text-muted">Генерируется автоматически, если поле пустое</small>
                </div>
            </li>
            <li class="col-md-6">
                <div class="form-group">
                    <label for="title">Title</label>
                    <input name="title"
                           type="text"
                           class="form-control"
                           id="title"
                           value="<?= $_POST['title'] ?? '' ?>">
                </div>
            </li>
            <li class="col-md-6">
                <div class="form-group">
                    <label for="meta_description">Meta description</label>
                    <input name="meta_description"
                           type="text"
                           class="form-control"
                           id="meta_description"
                           value="<?= $_POST['meta_description'] ?? '' ?>">
                </div>
            </li>
            <li class="col-md-6">
                <div class="form-group">
                    <label for="category">Категория</label>
                    <select name="category"
                            class="form-control"
                            required
                            id="category">
                        <option disabled selected>Не выбрана</option>
                        <?php
                        foreach (Category::all() as $category): ?>
                            <option
                                <?= isset($_POST['category']) && (int)$_POST['category'] === $category->getOriginal(
                                    'id'
                                ) ? 'selected' : '' ?>
                                    value="<?= $category->getOriginal('id') ?>"><?=
                                $category->getOriginal('name')
                                ?></option>
                        <?php
                        endforeach; ?>
                    </select>
                    <span class="text-danger"><?= isset($error['category']) ? $error['category'] : '' ?></span>
                </div>
            </li>
            <li class="col-md-6">
                <div class="form-group">
                    <label for="image">Картинка для превью</label>
                    <input name="image"
                           type="file"
                           class="form-control-file"
                           id="image"
                           accept="image/png, image/jpeg, image/jpg, image/gif">
                    <span class="text-danger"><?= isset($error['image']) ? $error['image'] : '' ?></span>
                </div>
            </li>
            <li class="col-md-12">
                <div class="form-group">
                    <label for="description">Короткое описание</label>
                    <textarea name="description"
                              class="form-control"
                              rows="3"
                              id="description"><?= $_POST['description'] ?? '' ?></textarea>
                </div>
            </li>
            <li class="col-md-12">
                <div class="form-group">
                    <label for="text">HTML статьи</label>
                    <textarea name="text"
                              class="form-control"
                              rows="10"
                              id="text"><?= $_POST['text'] ?? '' ?></textarea>
                </div>
            </li>
            <li class="col-md-6">
                <div class="form-group">
                    <input name="top"
                           type="checkbox"
                           class="checkbox"
                           id="top">
                    <label class="checkbox" for="top">Выводить в топе</label>
                </div>
            </li>
            <li class="col-md-6">
                <div class="form-group">
                    <input class="btn btn-primary ml-auto d-block"
                           type="submit"
                           id="save"
                           value="Сохранить">
                </div>
            </li>
        </ul>
    </form>
</div>

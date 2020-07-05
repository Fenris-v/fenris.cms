<?php

use App\Model\Category;

if (!empty($_POST)) {
    $category = new Category();
    $error = $category->addCategory();

    if (empty($error['success']) && $error['success'] === 'yes') {
        redirectOnPage('/admin/articles');
    }
} ?>

<div class="row">
    <form class="col-md-12" action="" method="post">
        <ul class="col-md-12 d-flex align-items-start flex-wrap">
            <li class="col-md-6">
                <div class="form-group">
                    <label for="name">Название категории</label>
                    <input name="name"
                           type="text"
                           class="form-control"
                           id="name"
                           required
                           value="<?= $_POST['name'] ?? '' ?>">
                    <span class="text-danger"><?= isset($error) ? $error : '' ?></span>
                </div>
            </li>
            <li class="col-md-6">
                <div class="form-group">
                    <label for="alias">Адрес категории</label>
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
                    <input class="btn btn-primary"
                           type="submit"
                           id="save"
                           value="Сохранить">
                </div>
            </li>
        </ul>
    </form>
</div>

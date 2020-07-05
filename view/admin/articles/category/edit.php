<?php

use App\Model\Category;

$categories = new Category();

if (!empty($_POST)) {
    $error = $categories->changeCategory($data[0]);
}

$category = $categories::all()->where('id', $data[0])->first();

?>
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
                           value="<?= $_POST['name'] ?? $category->name ?>">
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
                           value="<?= $_POST['alias'] ?? $category->uri ?>">
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
                           value="<?= $_POST['title'] ?? $category->meta_title ?>">
                </div>
            </li>
            <li class="col-md-6">
                <div class="form-group">
                    <label for="meta_description">Meta description</label>
                    <input name="meta_description"
                           type="text"
                           class="form-control"
                           id="meta_description"
                           value="<?= $_POST['meta_description'] ?? $category->meta_description ?>">
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

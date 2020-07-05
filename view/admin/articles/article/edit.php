<?php

use App\Model\Article;
use App\Model\Category;

$article = new Article();

if (!empty($_POST)) {
    $error = $article->editArticle((int)$data[0]);
}

$article = $article::all()->where('id', $data[0])->first(); ?>

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
                           value="<?= $article->title ?>">
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
                           value="<?= $article->uri ?>">
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
                           value="<?= $article->meta_title ?>">
                </div>
            </li>
            <li class="col-md-6">
                <div class="form-group">
                    <label for="meta_description">Meta description</label>
                    <input name="meta_description"
                           type="text"
                           class="form-control"
                           id="meta_description"
                           value="<?= $article->meta_description ?>">
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
                                <?= $article->category_id === $category->getOriginal('id') ? 'selected' : '' ?>
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
                    <?php
                    if ($article->image): ?>
                        <div class="d-flex align-items-center">
                            <img class="d-block" src="<?= $article->image ?>" alt="image" height="100">
                            <input name="removeImage"
                                   type="checkbox"
                                   class="checkbox ml-4"
                                   id="removeImage">
                            <label class="checkbox ml-2 mb-0" for="removeImage">Удалить</label>
                        </div>
                    <?php
                    else: ?>
                        <input name="image"
                               type="file"
                               class="form-control-file"
                               id="image"
                               accept="image/png, image/jpeg, image/jpg, image/gif">
                        <span class="text-danger"><?= $article->image ?></span>
                    <?php
                    endif; ?>
                </div>
            </li>
            <li class="col-md-12">
                <div class="form-group">
                    <label for="description">Короткое описание</label>
                    <textarea name="description"
                              class="form-control"
                              rows="3"
                              id="description"><?= $article->short_desc ?></textarea>
                </div>
            </li>
            <li class="col-md-12">
                <div class="form-group">
                    <label for="text">HTML статьи</label>
                    <textarea name="text"
                              class="form-control"
                              rows="10"
                              id="text"><?= $article->text ?></textarea>
                </div>
            </li>
            <li class="col-md-6">
                <div class="form-group">
                    <input name="top"
                           type="checkbox"
                           class="checkbox"
                        <?= $article->top === 1 ? 'checked' : '' ?>
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

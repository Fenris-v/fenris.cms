<?php

use App\Controller\CommentController;
use App\Exception\SaveException;
use App\Model\Article;
use App\Model\Category;
use App\Model\Comment;
use App\Model\User;

/** @noinspection PhpUndefinedVariableInspection */
$article = Article::all()->where('uri', $param[array_key_last($param)])->first();

if (isset($_POST['approve'])) {
    try {
        (new CommentController())->approveComment();
    } catch (SaveException $exception) {
        $error = $exception->getMessage();
    }
}

if (isset($_POST['delete'])) {
    try {
        (new CommentController())->removeComment();
    } catch (SaveException $exception) {
        $error = $exception->getMessage();
    }
}

if (isset($_POST['comment']) && trim($_POST['comment']) !== '' && isset($_SESSION['login'])) {
    try {
        (new CommentController())->saveComment($article->id);
    } catch (SaveException $exception) {
        $error = $exception->getMessage();
    }
    redirectOnPage($_SERVER['REQUEST_URI']);
}

try {
    /** @noinspection PhpUndefinedVariableInspection */
    includeView('layout.header', ['title' => $title, 'description' => $metaDescription]);
} catch (Exception $exception) {
    echo $exception->getMessage() . ' ' . $exception->getCode();
} ?>

    <section class="s_breadcrumb">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb align-items-center mb-0">
                    <li class="breadcrumb-item"><a href="/">Главная</a></li>
                    <?php
                    $link = '';
                    for ($i = 0; $i < count($param); $i++):
                        $link .= '/' . $param[$i]; ?>
                        <?php
                        if ($i !== array_key_last($param)) : ?>
                            <li class="breadcrumb-item d-flex align-items-center">
                                <a href="<?= $link ?>"><?=
                                    Category::all()
                                        ->where('uri', $param[$i])
                                        ->first()
                                        ->name
                                    ?></a>
                            </li>
                        <?php
                        else: ?>
                            <li class="breadcrumb-item active"
                                aria-current="page">
                                <?= $article->title ?>
                            </li>
                        <?php
                        endif;
                    endfor; ?>
                </ol>
            </nav>
        </div>
    </section>

    <section class="s_article">
        <div class="container">
            <div class="article">
                <h1 class="h2"><?= $title ?></h1>
                <p class="blog-post-meta mb-3"><?= $article->created_at ?> by
                    <a class="badge badge-pill badge-primary" href="#"><?= mb_ucfirst(
                            User::all()
                                ->where('id', $article->author_id)
                                ->first()
                                ->login
                        ) ?></a>
                </p>

                <img class="float-right mb-2 ml-2" style="max-width: 400px;" src="<?= $article->image ?>" alt="image">
                <?= $article->text ?>
            </div>
        </div>
    </section>
    <hr>
    <section class="s_comments">
        <div class="container">
            <h2 class="h2">Комментарии</h2>
            <?php
            $comments = Comment::all()->where('article_id', $article->id);
            $user = new User();

            if (
                (isset($_SESSION['login']) && isset($_SESSION['role']) && !isset($_SESSION['secret_code'])) &&
                ($user->isManager() || $user->isSuperUser())
            ):
                if ($comments->first() === null): ?>
                    <p>К этой статье пока не оставляли комментариев</p>
                <?php
                else: ?>
                    <ul class="d-flex flex-column">
                        <?php
                        foreach ($comments as $comment): ?>
                            <li class="badge badge-light p-3 text-left mb-3">
                                <p class="mb-3"><b><?= User::all()
                                            ->where('id', $comment->getOriginal('user_id'))
                                            ->first()
                                            ->login ?></b> <?= $comment->created_at ?></p>
                                <p class="mb-2"><?= $comment->getOriginal('text') ?></p>
                                <form method="post">
                                    <!--suppress HtmlFormInputWithoutLabel -->
                                    <input name="commentId"
                                           type="text"
                                           class="d-none"
                                           value="<?= $comment->getOriginal('id') ?>">
                                    <?php
                                    if ($comment->getOriginal('approve') === 0): ?>
                                        <input class="btn btn-primary" type="submit" name="approve" value="Подтвердить">
                                    <?php
                                    endif; ?>
                                    <input class="btn btn-primary" type="submit" name="delete" value="Удалить">
                                </form>
                            </li>
                        <?php
                        endforeach; ?>
                    </ul>
                <?php
                endif;
            else:
                if ($comments->where('approve', 1)->first() === null): ?>
                    <p>К этой статье пока не оставляли комментариев</p>
                <?php
                else: ?>
                    <ul class="d-flex flex-column">
                        <?php
                        foreach ($comments->where('approve', 1) as $comment): ?>
                            <li class="badge badge-light p-3 text-left mb-3">
                                <p class="mb-3"><b><?= User::all()
                                            ->where('id', $comment->getOriginal('user_id'))
                                            ->first()
                                            ->login ?></b>
                                    <?= $comment->created_at ?></p>
                                <p><?= $comment->getOriginal('text') ?></p>
                            </li>
                        <?php
                        endforeach; ?>
                    </ul>
                <?php
                endif;
            endif; ?>
        </div>
    </section>

    <section class="s_sendComment mb-3">
        <div class="container">
            <h2 class="h2">Оставить комментарий</h2>
            <form method="post">
                <!--suppress HtmlFormInputWithoutLabel -->
                <textarea name="comment"
                          class="form-control mb-3"
                          rows="3"
                          id="description"><?= $_POST['comment'] ?? '' ?></textarea>
                <?= isset($_POST['comment']) && !isset($_SESSION['login'])
                    ? '<span class="text-danger">Комментарии могут оставлять только авторизованные пользователи</span><br>' : '' ?>
                <span class="text-danger"><?= $error ?? '' ?></span>
                <input class="btn-primary btn" type="submit" value="Отправить">
            </form>
        </div>
    </section>

<?php
try {
    includeView('layout.footer');
} catch (Exception $exception) {
    echo $exception->getMessage() . ' ' . $exception->getCode();
}

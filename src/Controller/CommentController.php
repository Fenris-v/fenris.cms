<?php

namespace App\Controller;

use App\Exception\SaveException;
use App\Model\Comment;
use App\Model\User;

class CommentController extends PageController
{
    /**
     * Добавляет комментарий
     * @param int $articleId
     * @throws SaveException
     */
    public function saveComment(int $articleId): void
    {
        $user = new User();

        $comment = (new Comment())
            ->setArticleId($articleId)
            ->setText(trim($_POST['comment']))
            ->setUserId(User::all()->where('login', $_SESSION['login'])->first()->id)
            ->setApprove($user->isSuperUser() || $user->isManager() ? 1 : 0);

        $success = $comment->save();

        if (!$success) {
            throw new SaveException('Ошибка сохранения данных', 500);
        }

        redirectOnPage($_SERVER['REQUEST_URI']);
    }

    /**
     * Подтверждает комментарий
     * @throws SaveException
     */
    public function approveComment(): void
    {
        $comment = Comment::all()->where('id', $_POST['commentId'])->first();

        if ($comment === null) {
            throw new SaveException('Ошибка сохранения данных', 500);
        }

        $comment->setApprove(1);
        $success = $comment->save();

        if (!$success) {
            throw new SaveException('Ошибка сохранения данных', 500);
        }
        redirectOnPage($_SERVER['REQUEST_URI']);
    }

    /**
     * Удаляет комментарий
     * @throws SaveException
     */
    public function removeComment(): void
    {
        $comment = Comment::all()->where('id', $_POST['commentId'])->first();

        if ($comment === null) {
            throw new SaveException('Ошибка удаления', 500);
        }

        $success = $comment->delete();

        if (!$success) {
            throw new SaveException('Ошибка удаления', 500);
        }
        redirectOnPage($_SERVER['REQUEST_URI']);
    }
}

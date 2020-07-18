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
     * @return bool
     * @throws SaveException
     */
    public function saveComment(int $articleId): bool
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

        return $success;
    }

    /**
     * Подтверждает комментарий
     * @throws SaveException
     */
    public function approveComment(): bool
    {
        $comment = Comment::all()->where('id', $_POST['commentId'])->first();

        if ($comment === null) {
            return false;
        }

        $comment->setApprove(1);
        $success = $comment->save();

        if (!$success) {
            throw new SaveException('Ошибка сохранения данных', 500);
        }

        return $success;
    }

    /**
     * Удаляет комментарий
     * @throws SaveException
     */
    public function removeComment(): bool
    {
        $comment = Comment::all()->where('id', $_POST['commentId'])->first();

        if ($comment === null) {
            return false;
        }

        $success = $comment->delete();

        if (!$success) {
            throw new SaveException('Ошибка удаления', 500);
        }

        return $success;
    }
}

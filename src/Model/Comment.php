<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    /**
     * Добавляет комментарий
     * @param int $articleId
     */
    public function saveComment(int $articleId): void
    {
        $user = new User();

        $comment = new $this;
        $comment->article_id = $articleId;
        $comment->text = trim($_POST['comment']);
        $comment->user_id = User::all()->where('login', $_SESSION['login'])->first()->id;
        $comment->approve = $user->isSuperUser() || $user->isManager() ? 1 : 0;

        $comment->save();
    }

    /**
     * Подтверждает комментарий
     */
    public function approveComment(): void
    {
        $comment = $this::all()->where('id', $_POST['commentId'])->first();

        if ($comment === null) {
            return;
        }

        $comment->approve = 1;
        $comment->save();
    }

    /**
     * Удаляет комментарий
     */
    public function removeComment(): void
    {
        $comment = $this::all()->where('id', $_POST['commentId'])->first();

        if ($comment === null) {
            return;
        }

        $comment->delete();
    }
}

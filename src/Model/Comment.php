<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed article_id
 * @property mixed text
 * @property mixed user_id
 * @property mixed approve
 */
class Comment extends Model
{
    /**
     * @param $articleId
     * @return $this
     */
    public function setArticleId($articleId): Comment
    {
        $this->article_id = $articleId;
        return $this;
    }

    /**
     * @param $text
     * @return $this
     */
    public function setText($text): Comment
    {
        $this->text = $text;
        return $this;
    }

    /**
     * @param $userId
     * @return $this
     */
    public function setUserId($userId): Comment
    {
        $this->user_id = $userId;
        return $this;
    }

    /**
     * @param $approve
     * @return $this
     */
    public function setApprove($approve): Comment
    {
        $this->approve = $approve;
        return $this;
    }
}

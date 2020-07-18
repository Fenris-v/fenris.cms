<?php

namespace App\Model;

/**
 * Модель статей
 * Class Article
 * @property mixed|string title
 * @property mixed|string uri
 * @property mixed|string short_desc
 * @property mixed|string text
 * @property int|mixed author_id
 * @property mixed|string image
 * @property mixed|string meta_description
 * @property mixed|string meta_title
 * @property int|mixed top
 * @property int|mixed category_id
 * @package App\Model
 */
class Article extends Page
{
    /**
     * @param string $title
     * @return $this
     */
    public function setTitle(string $title): Article
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @param string $alias
     * @return $this
     */
    public function setUri(string $alias): Article
    {
        $this->uri = $alias;
        return $this;
    }

    /**
     * @param string $desc
     * @return $this
     */
    public function setShortDesc(string $desc): Article
    {
        $this->short_desc = $desc;
        return $this;
    }

    /**
     * @param string $text
     * @return $this
     */
    public function setText(string $text): Article
    {
        $this->text = $text;
        return $this;
    }

    /**
     * @param int $authorId
     * @return $this
     */
    public function setAuthor(int $authorId): Article
    {
        $this->author_id = $authorId;
        return $this;
    }

    /**
     * @param string $image
     * @return $this
     */
    public function setImage(?string $image): Article
    {
        $this->image = $image;
        return $this;
    }

    /**
     * @param string $metaDescription
     * @return $this
     */
    public function setMetaDescription(string $metaDescription): Article
    {
        $this->meta_description = $metaDescription;
        return $this;
    }

    /**
     * @param string $metaTitle
     * @return $this
     */
    public function setMetaTitle(string $metaTitle): Article
    {
        $this->meta_title = $metaTitle;
        return $this;
    }

    /**
     * @param int $top
     * @return $this
     */
    public function setTop(int $top): Article
    {
        $this->top = $top;
        return $this;
    }

    /**
     * @param int $categoryId
     * @return $this
     */
    public function setCategory(int $categoryId): Article
    {
        $this->category_id = $categoryId;
        return $this;
    }
}

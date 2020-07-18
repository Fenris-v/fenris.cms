<?php

namespace App\Model;

/**
 * Модель категорий
 * Class Category
 * @property mixed|string name
 * @property mixed|string uri
 * @property mixed|string meta_title
 * @property mixed|string meta_description
 * @package App\Model
 */
class Category extends Page
{
    /** @var bool Отключает запись времени для таблицы категорий */
    public $timestamps = false;

    /**
     * @param string $name
     * @return $this
     */
    public function setName(string $name): Category
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @param string $uri
     * @return $this
     */
    public function setUri(string $uri): Category
    {
        $this->uri = $uri;
        return $this;
    }

    /**
     * @param string $title
     * @return $this
     */
    public function setTitle(string $title): Category
    {
        $this->meta_title = $title;
        return $this;
    }

    /**
     * @param string $desc
     * @return $this
     */
    public function setDesc(string $desc): Category
    {
        $this->meta_description = $desc;
        return $this;
    }
}

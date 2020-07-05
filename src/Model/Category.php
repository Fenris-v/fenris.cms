<?php

namespace App\Model;

/**
 * Модель категорий
 * Class Category
 * @package App\Model
 */
class Category extends Page
{
    /** @var bool Отключает запись времени для таблицы категорий */
    public $timestamps = false;

    /**
     * Добавляет категорию
     * @return string|null - ошибки, если они есть
     */
    public function addCategory(): ?string
    {
        $name = mb_ucfirst(trim($_POST['name']));

        if (!$name) {
            return 'Название не может быть пустым';
        }

        if ($this::all()->where('name', $name)->first() !== null) {
            return 'Такая категория уже существует';
        }

        $alias = trim($_POST['alias']) !== '' ? $this->generateUri(trim($_POST['alias'])) : $this->generateUri($name);

        $category = new $this;

        $this->setData($category, $name, $alias);

        redirectOnPage('/admin/articles/list');

        return null;
    }

    /**
     * Изменение категории
     * @param int $id
     * @return string|null
     */
    public function changeCategory(int $id): ?string
    {
        $name = mb_ucfirst(trim($_POST['name']));

        if ($this::all()->where('id', '!=', $id)->where('name', $name)->first() !== null) {
            return 'Такая категория уже существует';
        }

        $alias = trim($_POST['alias']) !== '' ? $this->generateUri(trim($_POST['alias']), $id) : $this->generateUri($name);

        $category = $this::all()->where('id', $id)->first();

        $this->setData($category, $name, $alias);

        return null;
    }

    /**
     * Сохраняет данные
     * @param Category $category
     * @param string $name
     * @param string $alias
     * @noinspection PhpUndefinedFieldInspection
     */
    private function setData(Category $category, string $name, string $alias): void
    {
        $category->name = $name;
        $category->uri = $alias;
        $category->meta_title = $_POST['title'] ?? null;
        $category->meta_description = $_POST['meta_description'] ?? null;

        $category->save();
    }
}

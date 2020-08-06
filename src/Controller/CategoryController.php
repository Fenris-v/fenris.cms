<?php

namespace App\Controller;

use App\Exception\DataException;
use App\Exception\SaveException;
use App\Model\Category;

class CategoryController extends PageController
{
    /**
     * Добавляет категорию
     * @throws DataException
     * @throws SaveException
     */
    public function addCategory(): void
    {
        $name = mb_ucfirst(trim($_POST['name']));

        $errors = $this->checkData($name);

        if (!empty($errors)) {
            throw new DataException($errors);
        }

        $category = new Category();

        $alias = trim($_POST['alias']) !== ''
            ? $this->generateUri($category, trim($_POST['alias']))
            : $this->generateUri($category, $name);


        $success = $this->setData($category, $name, $alias);

        if (!$success) {
            throw new SaveException('Ошибка сохранения данных', 500);
        }

        redirectOnPage('/admin/articles/list');
    }

    /**
     * Изменение категории
     * @param int $id
     * @throws SaveException
     * @throws DataException
     */
    public function changeCategory(int $id): void
    {
        $name = mb_ucfirst(trim($_POST['name']));

        if (Category::all()->where('id', '!=', $id)->where('name', $name)->first() !== null) {
            throw new DataException(['category' => 'Такая категория уже существует']);
        }

        $alias = trim($_POST['alias']) !== ''
            ? $this->generateUri(new Category(), trim($_POST['alias']), $id)
            : $this->generateUri(new Category(), $name);

        $category = Category::all()->where('id', $id)->first();

        $success = $this->setData($category, $name, $alias);

        if (!$success) {
            throw new SaveException('Ошибка сохранения данных', 500);
        }

        redirectOnPage($_SERVER['REQUEST_URI']);
    }

    /**
     * Возвращает ошибки данных
     * @param $name - имя категории
     * @return array
     */
    private function checkData($name): array
    {
        if (!$name) {
            return ['category' => 'Название не может быть пустым'];
        }

        if (Category::all()->where('name', $name)->first() !== null) {
            return ['category' => 'Такая категория уже существует'];
        }

        return [];
    }

    /**
     * Сохраняет данные
     * @param Category $category
     * @param string $name
     * @param string $alias
     * @return bool
     */
    private function setData(Category $category, string $name, string $alias): bool
    {
        $category
            ->setName($name)
            ->setUri($alias)
            ->setTitle($_POST['title'] ?? null)
            ->setDesc($_POST['meta_description'] ?? null);

        return $category->save();
    }
}

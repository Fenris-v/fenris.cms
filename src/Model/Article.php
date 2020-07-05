<?php

namespace App\Model;

/**
 * Модель статей
 * Class Article
 * @package App\Model
 */
class Article extends Page
{
    /**
     * Проверяет данные для создания статьи
     * @return array - массив с ошибками, если они есть
     */
    public function addArticle(): array
    {
        $title = mb_ucfirst(trim($_POST['name']));

        $error = $this->checkData($title);

        if (!empty($error)) {
            return $error;
        }

        $alias = trim($_POST['alias']) !== '' ? $this->generateUri(trim($_POST['alias'])) : $this->generateUri($title);

        $image = '';
        if ($_FILES['image']['error'] === 0) {
            $image = $this->uploadImage($_FILES['image'], $alias);
        }

        $article = new $this;
        $this->saveData($article, (string)$title, (string)$alias, (string)$image);

        return ['success' => 'yes'];
    }

    /**
     * Редактирует статью
     * @param int $id
     * @return array
     */
    public function editArticle(int $id): array
    {
        $title = mb_ucfirst(trim($_POST['name']));

        $error = $this->checkData($title);

        if (!empty($error)) {
            return $error;
        }

        $article = $this::all()->where('id', $id)->first();
        $alias = trim($_POST['alias']) !== '' ? $this->generateUri(trim($_POST['alias']), $id) : $this->generateUri($title, $id);
        if (isset($_POST['removeImage']) && $_POST['removeImage'] === 'on') {
            $image = '';
            $this->removeImage((string)$article->image);
        } else {
            $image = isset($_FILES['image']) && $_FILES['image']['error'] === 0 ? $this->uploadImage($_FILES['image'], $alias) : '';
        }

        $this->saveData($article, (string)$title, (string)$alias, (string)$image);

        return $error;
    }

    /**
     * Возвращает ошибки данных
     * @param string $title
     * @return array
     */
    private function checkData(string $title): array
    {
        $error = [];

        if (!$title) {
            $error['title'] = 'Заголовок не может быть пустым';
        }

        if (!isset($_POST['category'])) {
            $error['category'] = 'Не выбрана категория';
        }

        if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
            if ($_FILES['image']['size'] > IMAGE_MAX_SIZE_B) {
                $error['image'] = 'Максимальный размер изображения ' . IMAGE_MAX_SIZE . 'мб';
            } elseif (!in_array(mime_content_type($_FILES['image']['tmp_name']), ALLOWED_IMAGES)) {
                $error['image'] = 'Недопустимое расширение файла';
            }
        }

        return $error;
    }

    /**
     * Сохраняет статью в БД
     * @param $article
     * @param string $title
     * @param string $alias
     * @param string $image
     */
    private function saveData($article, string $title, string $alias, string $image): void
    {
        $article->title = $title;
        $article->uri = $alias;
        $article->short_desc = $_POST['description'];
        $article->text = $_POST['text'];
        $article->author_id = User::all()->where('login', $_SESSION['login'])->first()->id;
        $article->image = $image;
        $article->meta_description = $_POST['meta_description'];
        $article->meta_title = $_POST['title'];
        $article->top = isset($_POST['top']) ? 1 : 0;
        $article->category_id = $_POST['category'];

        $article->save();
    }
}

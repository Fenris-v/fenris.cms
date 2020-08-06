<?php

namespace App\Controller;

use App\Exception\DataException;
use App\Exception\SaveException;
use App\Mail;
use App\Model\Article;
use App\Model\User;
use App\Traits\UploadImage;

class ArticleController extends PageController
{
    use UploadImage;

    public static array $errors;

    /**
     * Вызывает данные для проверки и добавления новой статьи
     * @throws SaveException
     * @throws DataException
     */
    public function addArticle(): void
    {
        $title = mb_ucfirst(trim($_POST['name']));

        $errors = $this->checkData($title);

        if (!empty($errors)) {
            throw new DataException($errors, 'Произошла ошибка при проверке данных');
        }

        $article = new Article();

        $alias = trim($_POST['alias']) !== ''
            ? $this->generateUri($article, trim($_POST['alias']))
            : $this->generateUri($article, $title);

        $image = '';
        if ($_FILES['image']['error'] === 0) {
            $image = $this->uploadImage($_FILES['image'], $alias, IMAGE_UPLOAD_DIR);
        }

        $userId = $this->getCurrentUserId();

        if ($userId === 0) {
            throw new SaveException('Ошибка сохранения данных', 500);
        }

        $success = $this->setData($article, $title, $alias, $image, $this->getCurrentUserId());

        if (!$success) {
            throw new SaveException('Ошибка сохранения данных', 500);
        }

        (new Mail())->mailing((string)$alias);

        redirectOnPage('/admin/articles');
    }

    /**
     * Редактирует статью
     * @param int $id
     * @throws DataException
     * @throws SaveException
     */
    public function editArticle(int $id): void
    {
        $title = mb_ucfirst(trim($_POST['name']));

        $errors = $this->checkData($title);

        if (!empty($errors)) {
            throw new DataException($errors, 'Произошла ошибка при проверке данных');
        }

        $article = Article::all()->where('id', $id)->first();
        $alias = trim($_POST['alias']) !== ''
            ? $this->generateUri($article, trim($_POST['alias']), $id)
            : $this->generateUri($title, $id);
        if (isset($_POST['removeImage']) && $_POST['removeImage'] === 'on') {
            $image = '';
            $this->removeImage((string)$article->image);
            $article->setImage(null);
        } else {
            $image = isset($_FILES['image']) && $_FILES['image']['error'] === 0
                ? $this->uploadImage($_FILES['image'], $alias, IMAGE_UPLOAD_DIR) : '';
        }

        $success = $this->setData(
            $article,
            $title,
            $alias,
            $image,
            User::all()->where('login', $_SESSION['login'])->first()->id
        );

        if (!$success) {
            throw new SaveException('Ошибка сохранения данных', 500);
        }

        redirectOnPage($_SERVER['REQUEST_URI']);
    }

    /**
     * Возвращает ошибки данных
     * @param string $title
     * @return array
     */
    private function checkData(string $title): array
    {
        $errors = [];

        if (!$title) {
            $errors['title'] = 'Заголовок не может быть пустым';
        }

        if (!isset($_POST['category'])) {
            $errors['category'] = 'Не выбрана категория';
        }

        if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
            if ($_FILES['image']['size'] > IMAGE_MAX_SIZE_B) {
                $errors['image'] = 'Максимальный размер изображения ' . IMAGE_MAX_SIZE . 'мб';
            } elseif (!in_array(mime_content_type($_FILES['image']['tmp_name']), ALLOWED_IMAGES)) {
                $errors['image'] = 'Недопустимое расширение файла';
            }
        }

        return $errors;
    }

    /**
     * Сохраняет изменения в БД / добавляет запись
     * @param Article $article
     * @param string $title - заголовок статьи
     * @param string $alias - путь до страницы статьи
     * @param string $image - путь до изображения
     * @param int $user - id пользователя
     * @return bool
     */
    private function setData(Article $article, string $title, string $alias, string $image, int $user = 0): bool
    {
        $article
            ->setTitle($title)
            ->setUri($alias)
            ->setShortDesc($_POST['description'])
            ->setText($_POST['text'])
            ->setMetaDescription($_POST['meta_description'])
            ->setMetaTitle($_POST['title'])
            ->setTop(isset($_POST['top']) ? 1 : 0)
            ->setCategory($_POST['category']);

        if ($user > 0) {
            $article->setAuthor($user);
        }

        if ($image) {
            $article->setImage($image);
        }

        return $article->save();
    }
}

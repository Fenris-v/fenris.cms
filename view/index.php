<?php

use App\Model\Book;

try {
    includeView('layout.header', ['title' => $title]);
} catch (Exception $exception) {
    echo $exception->getMessage() . ' ' . $exception->getCode();
} ?>

    <h1><?= $title ?></h1>

<?php
foreach (Book::all() as $book) {
    echo $book->getOriginal('id') . ') ' . $book->getOriginal('title') . ' - ' . $book->getOriginal('author') . '<br/>';
}

echo '<br/>';

try {
    includeView('layout.footer');
} catch (Exception $exception) {
    echo $exception->getMessage() . ' ' . $exception->getCode();
}

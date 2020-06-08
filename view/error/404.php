<?php

try {
    includeView('layout.header', ['title' => $this->getCode() . ' ' . $this->getMessage()]);
} catch (Exception $exception) {
    echo $exception->getMessage() . ' ' . $exception->getCode();
} ?>

    <h1><?= $this->getCode() . ' ' . $this->getMessage(); ?></h1>

<?php
try {
    includeView('layout.footer');
} catch (Exception $exception) {
    echo $exception->getMessage() . ' ' . $exception->getCode();
}

<?php

try {
    includeView('layout.header', ['title' => $this->getCode() . ' ' . $this->getMessage()]);
} catch (Exception $exception) {
    echo $exception->getMessage() . ' ' . $exception->getCode();
}

if ((int)$this->getCode() === 404): ?>
    <h1 class="cyber position-absolute undefinedPage text-center"><?= $this->getCode() . '<br>Not Found!<br>'; ?></h1>
<?php
else: ?>
    <h1><?= $this->getCode() . ' ' . $this->getMessage(); ?></h1>
<?php
endif;
try {
    includeView('layout.footer');
} catch (Exception $exception) {
    echo $exception->getMessage() . ' ' . $exception->getCode();
}

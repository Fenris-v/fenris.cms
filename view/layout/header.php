<?php

try {
    includeView('layout.head', $data);

    if (strpos($_SERVER['REQUEST_URI'], 'admin')) {
        includeView('layout.admin_header', $data);
    } else {
        includeView('layout.base.header', $data);
    }
} catch (Exception $exception) {
    echo $exception->getMessage() . ' ' . $exception->getCode();
}

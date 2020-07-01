<?php

try {
    if (strpos($_SERVER['REQUEST_URI'], 'admin')) {
        includeView('layout.admin_footer');
    } else {
        includeView('layout.base.footer');
    }
} catch (Exception $exception) {
    echo $exception->getMessage() . ' ' . $exception->getCode();
}

<?php

try {
    if (isset($isAdmin) && $isAdmin) {
        includeView('layout.admin_header', ['title' => $title]);
    } else {
        includeView('layout.base.header', ['title' => $title]);
    }
} catch (Exception $exception) {
    echo $exception->getMessage() . ' ' . $exception->getCode();
}

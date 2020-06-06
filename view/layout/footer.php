<?php

try {
    if (isset($isAdmin) && $isAdmin) {
        includeView('layout.admin_footer');
    } else {
        includeView('layout.base.footer');
    }
} catch (Exception $exception) {
    echo $exception->getMessage() . ' ' . $exception->getCode();
}

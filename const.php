<?php

define('APP_DIR', $_SERVER['DOCUMENT_ROOT']);
define('VIEW_DIR', APP_DIR . '/view/');
define('CONFIG_DIR', APP_DIR . '/configs/');
define('TEMPLATES_CMS_DIR', APP_DIR . '/templates/');
define('JS_CMS_DIR', TEMPLATES_CMS_DIR . 'js/');
define('CSS_CMS_DIR', TEMPLATES_CMS_DIR . 'css/');
define('LOG_DIR', APP_DIR . '/log/');

define('MIN_LOGIN_LENGTH', 4);
define('MIN_PASSWORD_LENGTH', 8);
define('SECRET_CODE_LIFE', 15);

define('NO_REPLY_MAIL', 'no-reply@fenris.cms');

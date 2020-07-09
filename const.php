<?php

define('APP_DIR', $_SERVER['DOCUMENT_ROOT']);
define('VIEW_DIR', APP_DIR . '/view/');
define('CONFIG_DIR', APP_DIR . '/configs/');
define('TEMPLATES_CMS_DIR', APP_DIR . '/templates/');
define('JS_CMS_DIR', TEMPLATES_CMS_DIR . 'js/');
define('CSS_CMS_DIR', TEMPLATES_CMS_DIR . 'css/');
define('LOG_DIR', APP_DIR . '/log/');
define('IMAGE_DIR', TEMPLATES_CMS_DIR . 'images/');
define('IMAGE_UPLOAD_DIR', IMAGE_DIR . 'upload/');
define('AVATAR_UPLOAD_DIR', IMAGE_DIR . 'avatar/');
define('IMAGE_PATH', '/templates/images/upload/');
define('AVATAR_PATH', '/templates/images/avatar/');

define('MIN_LOGIN_LENGTH', 4);
define('MIN_PASSWORD_LENGTH', 8);
define('SECRET_CODE_LIFE', 15);
define('DEFAULT_ROLE', 3);
define('IMAGE_MAX_SIZE', 5);
define('IMAGE_MAX_SIZE_B', IMAGE_MAX_SIZE * 1024 * 1024);
define('AVATAR_MAX_SIZE', 2);
define('AVATAR_MAX_SIZE_B', AVATAR_MAX_SIZE * 1024 * 1024);

define('ALLOWED_IMAGES', ['image/jpg', 'image/jpeg', 'image/png', 'image/gif']);

define('NO_REPLY_MAIL', 'no-reply@fenris.cms');
define('BLOG_MAIL', 'fenris-blog@fenris.cms');

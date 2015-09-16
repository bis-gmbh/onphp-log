<?php
// system settings
error_reporting(E_ALL | E_STRICT);
setlocale(LC_CTYPE, "ru_RU.UTF8");
setlocale(LC_TIME, "ru_RU.UTF8");

define('DEFAULT_ENCODING', 'UTF-8');
mb_internal_encoding(DEFAULT_ENCODING);
mb_regex_encoding(DEFAULT_ENCODING);

// paths
define('PATH_BASE', dirname(__FILE__) . DIRECTORY_SEPARATOR);
define('PATH_ROOT', dirname(PATH_BASE) . DIRECTORY_SEPARATOR);
define('PATH_VENDOR', PATH_ROOT . 'vendor' . DIRECTORY_SEPARATOR);
define('PATH_ONPHP', PATH_VENDOR . 'bis-gmbh' . DIRECTORY_SEPARATOR . 'onphp' . DIRECTORY_SEPARATOR);

define('PATH_SOURCE', PATH_ROOT . 'src' . DIRECTORY_SEPARATOR);
define('PATH_EXAMPLES', PATH_ROOT . 'examples' . DIRECTORY_SEPARATOR);

define('PATH_TEMPLATES', PATH_EXAMPLES . 'templates' . DIRECTORY_SEPARATOR);

require PATH_VENDOR . 'autoload.php';

// onPHP init
require PATH_ONPHP . 'global.inc.php.tpl';

define('__LOCAL_DEBUG__', true);
define('BUGLOVERS', 'mailbox@example.net');

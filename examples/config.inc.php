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

define('PATH_CLASSES', PATH_BASE . 'classes' . DIRECTORY_SEPARATOR);

define('PATH_LOGS', PATH_EXAMPLES . 'logs' . DIRECTORY_SEPARATOR);

require PATH_VENDOR . 'autoload.php';

// onPHP init
require PATH_ONPHP . 'global.inc.php.tpl';
$onphpAutoloader = \Onphp\AutoloaderPool::get('onPHP');
$onphpAutoloader->addPaths([
    PATH_CLASSES . 'Auto' . DIRECTORY_SEPARATOR . 'Business' . DIRECTORY_SEPARATOR,
    PATH_CLASSES . 'Auto' . DIRECTORY_SEPARATOR . 'DAOs' . DIRECTORY_SEPARATOR,
    PATH_CLASSES . 'Auto' . DIRECTORY_SEPARATOR . 'Proto' . DIRECTORY_SEPARATOR,
    PATH_CLASSES . 'Business' . DIRECTORY_SEPARATOR,
    PATH_CLASSES . 'DAOs' . DIRECTORY_SEPARATOR,
    PATH_CLASSES . 'Proto' . DIRECTORY_SEPARATOR,
], 'Onphp\Log\Examples');

// Db init
$db = \Onphp\DB::spawn('\Onphp\MySQLim', 'onphp_log', 'onphp_log', '127.0.0.1', 'onphp_log')->
    setPersistent(false)->
    setEncoding('utf8')->
    setNeedAutoCommit(true);
\Onphp\DBPool::me()->
    addLink('onphp_log', $db)->
    setDefault($db);

\Onphp\Log\LoggerRepository::add([
    new \Onphp\Log\LoggerInstance(
        'runtime',
        [
            new \Onphp\Log\Target\StreamTarget(PATH_LOGS . 'index.log'),
            new \Onphp\Log\Target\OnphpDAOTarget(\Onphp\Log\Examples\Log::create()),
        ],
        [
            new \Onphp\Log\Informer\ExceptionInformer(),
            new \Onphp\Log\Informer\HttpRequestInformer(),
        ]
    ),
]);

define('__LOCAL_DEBUG__', true);
define('BUGLOVERS', 'mailbox@example.net');

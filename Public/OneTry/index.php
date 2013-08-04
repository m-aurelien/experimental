<?php

include_once __DIR__ . '/../../Library/Loader.php';

define('SERVER_ROOT', '/opt/local/apache2/htdocs/projects/experimental/');
//define('SERVER_ROOT', 'C:/wamp/www/experimental/');
define('SITE_ROOT', 'http://localhost/experimental/onetry');
define('APP_NAME', 'OneTry');

\Library\Loader::init();

$app = new \Applications\OneTry\FrontApplication();
$app->run();

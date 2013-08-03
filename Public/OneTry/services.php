<?php

include_once __DIR__ . '/../../Library/Loader.php';

//define('SERVER_ROOT' , '/opt/local/apache2/htdocs/projects/experimental/');
define('SERVER_ROOT' , 'C:/wamp/www/experimental/');
define('SITE_ROOT' , 'http://localhost/experimental/onetry');

\Library\Loader::init();

$rest = new \Library\WebService\RestServer('\Applications\OneTry\Services\WebServices\\');
$rest->handle();
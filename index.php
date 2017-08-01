<?php


declare(strict_types = 1);

ini_set('session.cookie_httponly', '1');
ini_set('session.use_only_cookies', '1');
ini_set('session.cookie_secure', '1');

$container = require __DIR__ . '/app/bootstrap.php';
$container->getService('application')->run();

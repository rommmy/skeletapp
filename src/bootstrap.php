<?php

/**
 * Application bootstraping
 */

namespace Skeletapp;

use Skeletapp\Application;

require __DIR__ . '/../vendor/autoload.php';

error_reporting(E_ALL | E_STRICT);

date_default_timezone_set(ini_get('date.timezone') ?: 'UTC');

if (!defined('APP_ROOT_PATH')) {
    define('APP_ROOT_PATH', __DIR__ . '/..');
}

if (!defined('APP_ENVIRONNEMENT')) {
    if (stripos($_SERVER['HTTP_HOST'], 'dev') !== false) {
      define('APP_ENVIRONNEMENT', 'dev');
    }
    else {
        define('APP_ENVIRONNEMENT', 'prod');
    }
}

if (!defined('DEBUG')) {
    define('DEBUG', true);
}

/**
* Error handler
*/
$whoops = new \Whoops\Run;

if (APP_ENVIRONNEMENT !== 'production') {
    $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
}
else {
    $whoops->pushHandler(function($e) {
        echo 'Friendly error page and send an email to the developer';
    });
}

$whoops->register();

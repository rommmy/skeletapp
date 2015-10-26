<?php

require __DIR__ . '/../src/bootstrap.php';

use Skeletapp\Application,
    Skeletapp\Modules\ModuleLoader;

$injector = new \Auryn\Injector;
$loader = new ModuleLoader;

$app = new Application($injector);

foreach (['RenderingModule'] as $module) {
    $loader->load($app, $module);
}

require __DIR__ . '/../src/routes.php';

$app->run();

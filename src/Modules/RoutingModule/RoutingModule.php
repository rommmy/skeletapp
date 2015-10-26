<?php

namespace Skeletapp\Modules\RoutingModule;

use Skeletapp\Application;

/**
 * Routing module
 *
 * @package default
 */
class RoutingModule implements \Skeletapp\Modules\Module
{
    public function register(Application $app)
    {
        $app
            ->route('GET', '/', function() { return 'home';})
            ->route('GET', '/2', 'Skeletapp\Controllers\Homepage::get')
            ->route('GET', '/3', ['Skeletapp\Controllers\Homepage', 'get'])
        ;
    }
}

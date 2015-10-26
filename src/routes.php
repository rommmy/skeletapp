<?php

namespace Skeletapp;

/**
 *
 * Application routes
 *
 */

$app
    ->route('GET', '/', function() { return 'home';})
    ->route('GET', '/2', 'Skeletapp\Controllers\Homepage::get')
    ->route('GET', '/3', ['Skeletapp\Controllers\Homepage', 'get'])
;

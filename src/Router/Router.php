<?php

namespace Skeletapp\Router;

interface Router
{
    public function addRoute($method, $pattern, $handler);
    public function dispatch($method, $path);
}

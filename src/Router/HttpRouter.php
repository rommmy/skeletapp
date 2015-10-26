<?php

namespace Skeletapp\Router;

/**
 * Dummy wrapper on top of the awesome fastRoute package
 * by nikiC.
 *
 * https://github.com/nikic/FastRoute
 * @package default
 */
class HttpRouter implements Router
{
    protected $routes = [];
    protected $dispatcher = null;
    protected static $allowedMethods = [
        'GET', 'POST', 'PUT', 'DELETE', 'PATCH', 'HEAD', 'OPTIONS'
    ];

    /**
     * Constructor
     *
     * @param array $routes
     */
    public function __construct(array $routes = [])
    {
        $this->routes = $routes;
    }

    /**
     * Dispatch a request
     *
     * @param  [type] $method [description]
     * @param  [type] $path   [description]
     * @return [type]         [description]
     */
    public function dispatch($method, $path)
    {
        if (is_null($this->dispatcher)) {
            $this->setupDispatcher();
        }

        return $this->dispatcher->dispatch($method, $path);
    }

    /**
     * Add a route
     *
     * @param [type] $method  [description]
     * @param [type] $pattern [description]
     * @param [type] $handler [description]
     */
    public function addRoute($method, $pattern, $handler)
    {
        if (in_array($method, self::$allowedMethods)) {
            $this->routes[] = [$method, $pattern, $handler];
        }
    }

    /**
     * Sets up the dispatcher
     *
     * @return [type] [description]
     */
    private function setupDispatcher()
    {
        $callback = function (\FastRoute\RouteCollector $r) {
            foreach ($this->routes as $route) {
                $r->addRoute($route[0], $route[1], $route[2]);
            }
        };

        $this->dispatcher = \FastRoute\simpleDispatcher($callback);
    }
}
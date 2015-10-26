<?php

namespace Skeletapp;

use \Auryn\Injector,
    Skeletapp\Router\Router,
    Skeletapp\Router\HttpRouter,
    Symfony\Component\HttpFoundation\Request,
    Symfony\Component\HttpFoundation\Response;

/**
 * Application class
 *
 * @package default
 */
class Application
{
    protected $injector;
    protected $router;
    protected $request;
    protected $response;
    protected $modules = [];

    public function __construct(
        Injector $injector = NULL,
        Router $router = NULL,
        $config = [])
    {
        $this->injector = $injector ?: new Injector;
        $this->router = $router ?: new HttpRouter;
    }

    public function getInjector()
    {
        return $this->injector;
    }

    public function run(Request $request = NULL)
    {
        if (!is_null($request)) {
            $this->request = $request;
            $this->injector->share($request);
        }
        else {
            $this->request = Request::createFromGlobals();
        }

        $this->response = new Response;

        $this->injector->share($this->request);
        $this->injector->share($this->response);

        try {
            $dispatched = $this->router->dispatch(
                $this->request->getMethod(),
                $this->request->getPathInfo()
            );

            switch ($dispatched[0]) {
                case \FastRoute\Dispatcher::NOT_FOUND:
                    $this->response->setContent('404 - Page not found');
                    $this->response->setStatusCode(404);
                    break;
                case \FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
                    $this->response->setContent('405 - Method not allowed');
                    $this->response->setStatusCode(405);
                    break;
                case \FastRoute\Dispatcher::FOUND:
                    // $className = $dispatched[1][0];
                    // $method = $dispatched[1][1];
                    // $vars = $dispatched[2];

                    // $class = $this->injector->make($className);
                    // $class->$method($vars);
                    $handler = $dispatched[1];
                    $vars = $dispatched[2];
                    $this->call($handler, $vars);
                    break;
            }

            $this->response->send();
        }
        catch (\Exception $e) {
            echo $e->getMessage(); die;
        }
        
    }

    /**
     * Add a route
     *
     * @param  [type] $method
     * @param  [type] $pattern
     * @param  [type] $handler
     * @return [type]
     */
    public function route($method, $pattern, $handler)
    {
        $this->router->addRoute($method, $pattern, $handler);

        return $this;
    }

    /**
     * A module has been loaded
     *
     * @param  [type] $moduleName [description]
     * @return [type]             [description]
     */
    public function moduleLoaded($moduleName)
    {
        $this->modules[] = $moduleName;
    }

    /**
     * Call the handler of the router's dispatcher
     *
     * @param  [type] $handler [description]
     * @param  array  $args    [description]
     * @return [type]          [description]
     */
    private function call($handler, array $args)
    {
        $injections = [
            ':request' => $this->request,
            ':response' => $this->response
        ];

        if (count($args)) {
            foreach ($args as $arg => $value) {
                $injections[":{$arg}"] = $value;
            }
        }

        $result = $this->injector->execute($handler, $injections);

        if ($result instanceOf Response) {
            $this->response = $result;
            $this->injector->share($result);
        }

        $this->response->send();
        die;
    }
}

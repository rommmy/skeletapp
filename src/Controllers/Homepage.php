<?php

namespace Skeletapp\Controllers;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Homepage Controller
 *
 * @package default
 */
class Homepage
{
    protected $request;
    protected $response;

    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    public function get()
    {
        $this->response->setContent('Hello ' . $this->request->get('name', 'dummy'));
    }
}

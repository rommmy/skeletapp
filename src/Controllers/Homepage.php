<?php

namespace Skeletapp\Controllers;

use Symfony\Component\HttpFoundation\Request,
    Symfony\Component\HttpFoundation\Response,
    Skeletapp\Renderer\Renderer;

/**
 * Homepage Controller
 *
 * @package default
 */
class Homepage
{
    protected $request;
    protected $response;
    protected $renderer;

    /**
     * Constructor
     *
     * @param Request  $request  [description]
     * @param Response $response [description]
     * @param Renderer $renderer [description]
     */
    public function __construct(
        Request $request,
        Response $response,
        Renderer $renderer
    )
    {
        $this->request = $request;
        $this->response = $response;
        $this->renderer = $renderer;
    }

    /**
     * Get homepage
     *
     * @return [type] [description]
     */
    public function get()
    {
        $content = $this->renderer->render(
            'home',
            ['name' => $this->request->get('name', 'dummy')]
        );

        $this->response->setContent($content);
    }
}

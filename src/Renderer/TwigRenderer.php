<?php

namespace Skeletapp\Renderer;

/**
 * Twig renderer implementation
 *
 * @package default
 */
class TwigRenderer implements Renderer
{
    /** @var \Twig_Environment Twig engine */
    protected $engine;

    /**
     * TwigRenderer Constructor
     *
     * @param \Twig_Environment $engine [description]
     */
    public function __construct(\Twig_Environment $engine)
    {
        $this->engine = $engine;
    }

    /**
     * Render the template
     *
     * @param  [type] $template [description]
     * @param  array  $data     [description]
     * @return [type]           [description]
     */
    public function render($template, array $data = [])
    {
        if (stripos($template, '.html') === false) {
            $template .= '.html';
        }

        return $this->engine->render($template, $data);
    }
}
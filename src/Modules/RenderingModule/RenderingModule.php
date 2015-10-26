<?php

namespace Skeletapp\Modules\RenderingModule;

use Skeletapp\Application,
    Skeletapp\Modules\Module,
    \Twig_Environment,
    \Twig_Loader_Filesystem;

/**
 * Rendering module
 *
 * @package default
 */
class RenderingModule implements Module
{
    /**
     * Register the module onto our application
     *
     * @param  Application $app [description]
     * @return
     */
    public function register(Application $app)
    {
        $app->getInjector()->alias(
            'Skeletapp\Renderer\Renderer',
            'Skeletapp\Renderer\TwigRenderer'
        );

        // $app->getInjector()->define('Twig_Environment', [
        //     ':loader' => $loader,
        //     ':options' => []
        // ]);

        $app->getInjector()->delegate('Twig_Environment', function() use ($app) {
            $loader = new Twig_Loader_Filesystem(APP_ROOT_PATH . '/templates');
            $twig = new Twig_Environment($loader);

            return $twig;
        });
    }
}

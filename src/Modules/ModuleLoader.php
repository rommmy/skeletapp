<?php

namespace Skeletapp\Modules;

use Skeletapp\Application,
    Skeletapp\Modules\Module;

/**
 * Module Loader
 * 
 * Allows external services to access
 * the application and configure the injector
 * 
 * @package default
 */
class ModuleLoader 
{
    const BASE_NAMESPACE = 'Skeletapp\Modules';

    /**
     * Load a module
     *
     * @param type Application $app 
     * @param type $moduleName 
     * @return type
     */
    public function load(Application $app, $moduleName)
    {
        $modulePath = sprintf(
            '%s\%s\%s',
            self::BASE_NAMESPACE,
            $moduleName, $moduleName
        );

        if (!class_exists($modulePath) && !class_exists($moduleName)) {
            throw new \Exception(sprintf("Can't find module %s", $moduleName));
        }

        $module = class_exists($moduleName) 
            ? $app->getInjector()->make($moduleName)
            : new $modulePath;

        if (!$module instanceOf Module) {
            throw new \Exception(
                sprintf("%s must implement Skeletapp\Modules\Module interface", $moduleName)
            );
        }

        $module->register($app);
        $app->moduleLoaded($moduleName);
    }
}

<?php

namespace Skeletapp\Modules;

use Skeletapp\Application;

interface Module
{
    public function register(Application $app);
}

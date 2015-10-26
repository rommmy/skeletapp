<?php

namespace Skeletapp\Renderer;

interface Renderer
{
    public function render($template, array $data = []);
}

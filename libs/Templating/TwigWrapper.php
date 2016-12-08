<?php

namespace Templating;


use Application\Config;
use Windwalker\Renderer\TwigRenderer;

class TwigWrapper implements ITemplateWrapper
{

    /**
     * @var TwigRenderer
     */
    private $twig;

    public function initialize()
    {

        $this->twig = new TwigRenderer(DIR_APP . Config::getParam("layout_dir"), array('cache_path' => DIR_TEMP));

    }

    public function render($path, $variables)
    {
        $path = str_replace(DIR_APP.Config::getParam("layout_dir"), "", $path);
        return $this->twig->render($path, $variables);
    }


}
<?php

namespace Templating;


use Application\Config;
use Windwalker\Renderer\TwigRenderer;

/**
 * Twig templating engine wrapper.
 *
 * @author Juraj Čarnogurský
 * Class TwigWrapper
 * @package Templating
 */
class TwigWrapper implements ITemplateWrapper
{

    /**
     * @var TwigRenderer
     */
    private $twig;

    /**
     * @inheritdoc
     */
    public function initialize()
    {

        $this->twig = new TwigRenderer(DIR_APP . Config::getParam("layout_dir"), array('cache_path' => DIR_TEMP));

    }

    /**
     * @inheritdoc
     */
    public function render($path, $variables)
    {
        $path = str_replace(DIR_APP.Config::getParam("layout_dir"), "", $path);
        return $this->twig->render($path, $variables);
    }


}
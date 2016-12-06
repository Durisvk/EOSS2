<?php

namespace Templating;


use Application\Config;

class TwigWrapper implements ITemplateWrapper
{

    /**
     * @var \Twig_Environment
     */
    private $twig;

    public function initialize()
    {
        require_once DIR_LIBS . 'Twig/lib/Twig/Autoloader.php';
        \Twig_Autoloader::register();

        $loader = new \Twig_Loader_Filesystem(DIR_APP . Config::getParam("layout_dir"));
        $this->twig = new \Twig_Environment($loader, array(
            'cache' => DIR_TEMP,
        ));
    }

    public function render($path, $variables)
    {
        $path = explode(DIRECTORY_SEPARATOR, $path);
        return $this->twig->render(end($path), $variables);
    }


}
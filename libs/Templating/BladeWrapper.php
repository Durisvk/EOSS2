<?php
/**
 * Created by PhpStorm.
 * User: juraj
 * Date: 12/8/16
 * Time: 5:31 PM
 */

namespace Templating;


use Application\Config;
use Debug\Linda;
use Windwalker\Renderer\BladeRenderer;

class BladeWrapper implements ITemplateWrapper
{

    /**
     * @var BladeRenderer
     */
    private $blade;

    public function initialize()
    {

        $this->blade = new BladeRenderer(DIR_APP . Config::getParam("layout_dir"), array('cache_path' => DIR_TEMP));

    }

    public function render($path, $variables)
    {
        $path = str_replace(DIR_APP.Config::getParam("layout_dir"), "", $path);
        return $this->blade->render($path, $variables);
    }


}
<?php
/**
 * Created by PhpStorm.
 * User: juraj
 * Date: 12/8/16
 * Time: 5:31 PM
 */

namespace Templating;


use Application\Config;
use Windwalker\Renderer\BladeRenderer;

/**
 * Blade templating engine wrapper.
 *
 * @author Juraj Čarnogurský
 * Class BladeWrapper
 * @package Templating
 */
class BladeWrapper implements ITemplateWrapper
{

    /**
     * @var BladeRenderer
     */
    private $blade;

    /**
     * @inheritdoc
     */
    public function initialize()
    {

        $this->blade = new BladeRenderer(DIR_APP . Config::getParam("layout_dir"), array('cache_path' => DIR_TEMP));

    }

    /**
     * @inheritdoc
     */
    public function render($path, $variables)
    {
        $path = str_replace(DIR_APP.Config::getParam("layout_dir"), "", $path);
        return $this->blade->render($path, $variables);
    }


}
<?php
/**
 * Created by PhpStorm.
 * User: juraj
 * Date: 12/8/16
 * Time: 6:17 PM
 */

namespace Templating;


use Latte\Engine;

/**
 * Latte templating engine wrapper.
 *
 * @author Juraj Čarnogurský
 * Class LatteWrapper
 * @package Templating
 */
class LatteWrapper implements ITemplateWrapper
{

    /**
     * @var Engine
     */
    private $latte;

    /**
     * @inheritdoc
     */
    public function initialize()
    {

        $this->latte = new Engine();

        $this->latte->setTempDirectory(rtrim(DIR_TEMP, "/"));

    }

    /**
     * @inheritdoc
     */
    public function render($path, $variables)
    {
        //$path = str_replace(DIR_APP.Config::getParam("layout_dir"), "", $path);
        return $this->latte->renderToString($path, $variables);
    }

}
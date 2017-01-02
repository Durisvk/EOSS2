<?php

namespace Templating;


/**
 * Templating engine wrapper interface.
 *
 * @author Juraj Čarnogurský
 * Interface ITemplateWrapper
 * @package Templating
 */
interface ITemplateWrapper
{

    /**
     * Initializes the wrapper
     */
    public function initialize();

    /**
     * Renders the file at path.
     * @param string $path
     * @param array $variables
     * @return string
     */
    public function render($path, $variables);

}
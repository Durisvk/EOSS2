<?php

namespace Templating;


/**
 * Factory for templating wrappers.
 * Class TemplateFactory
 * @package Templating
 */
class TemplateFactory
{

    /**
     * @param string $filename
     * @return ITemplateWrapper|NULL
     */
    public static function create($filename) {
        $ext = strstr($filename, '.');
        $ext = ltrim($ext, '.');
        switch($ext) {
            case "twig.php": return new TwigWrapper();
        }

        return NULL;
    }

}
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
        $filename = basename($filename);
        $ext = strstr($filename, '.');
        $ext = ltrim($ext, '.');
        switch($ext) {
            case "twig.php": return new TwigWrapper();
            case "blade.php": return new BladeWrapper();
            case "latte.php": return new LatteWrapper();
        }

        return NULL;
    }

}
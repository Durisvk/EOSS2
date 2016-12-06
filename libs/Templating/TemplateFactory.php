<?php

namespace Templating;


use Debug\Linda;

class TemplateFactory
{

    /**
     * @param string $filename
     * @return ITemplateWrapper|NULL
     */
    public static function create($filename) {
        $ext = strstr($filename, '.');
        $ext = ltrim($ext, '.');
        Linda::dump($ext);
        switch($ext) {
            case "twig.php": return new TwigWrapper();
        }

        return NULL;
    }

}
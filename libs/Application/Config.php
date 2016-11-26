<?php

namespace Application;


/**
 * Reads the configuration file.
 * Class Config
 * @package Application\Config
 */
class Config
{

    /**
     * @var null|string Content of configuration file.
     */
    private static $file = NULL;

    /**
     * Returns the parameter of the configuration file.
     * @param string $param
     * @param bool $need
     * @return mixed
     * @throws \Exception
     */
    public static function getParam($param, $need = FALSE) {
        if(!self::$file) {
            self::$file = file_get_contents (DIR_APP."config.eoss");
        }
        $rf = "{".self::$file."}";
        $config=json_decode($rf);
        if(isset($config->$param)) {
            return $config->$param;
        } else if($need) {
            throw new \Exception("Parameter \"{$param}\" not found in configuration file");
        }

        return NULL;
    }

}
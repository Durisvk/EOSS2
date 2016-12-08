<?php

namespace Application;
use Debug\Linda;
use Utils\JSON;


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

        if($param == 'services') {
            if(file_exists(DIR_APP."services.eoss")) {
                $file = file_get_contents(DIR_APP."services.eoss");
                $json = JSON::decode($file);
                return $json["services"];
            } else return [];
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
<?php

namespace EOSS;

use Utils\Session;

class Registry
{


    /**
     * @var array
     */
    private $params = [];

    /**
     * @var null|Registry
     */
    private static $instance = NULL;

    /**
     * Registry constructor.
     */
    private function __construct() {
        if($params = Session::getInstance()->get("registryEOSS")) {
            $this->params = $params;
        }
    }


    public function __destruct()
    {
        Session::getInstance()->set("registryEOSS", $this->params);
    }

    /**
     * Gets the parameter into registry or throws an Exception.
     * @param string $key
     * @return mixed
     * @throws \Exception
     */
    public function __get($key) {
        if(isset($this->params[$key])) {
            return $this->params[$key];
        } else {
            throw new \Exception("Can't find the parameter {$key} inside Registry.");
        }
    }

    /**
     * Sets the parameter into registry.
     * @param string $key
     * @param mixed $value
     */
    public function __set($key, $value) {
        $this->params[$key] = $value;
    }


    /**
     * Gets the registry instance. Singleton pattern.
     * @return Registry
     */
    public static function getInstance() {

        if(!self::$instance) {
            self::$instance = new Registry();
        }

        return self::$instance;
    }

}
<?php

namespace EOSS;

/**
 * CSI holds this class to pass the variables into view
 * Class Parameters
 * @package EOSS
 */
class Parameters
{

    /**
     * @var array
     */
    private $params = [];

    /**
     * Gets the parameter or throws an Exception.
     * @param string $key
     * @return mixed
     * @throws \Exception
     */
    public function __get($key) {
        if(isset($this->params[$key])) {
            return $this->params[$key];
        } else {
            throw new \Exception("Can't find the parameter {$key} inside CSI.");
        }
    }

    /**
     * Sets the parameter.
     * @param string $key
     * @param mixed $value
     */
    public function __set($key, $value) {
        $this->params[$key] = $value;
    }

    /**
     * Returns all of the parameters as array.
     * @return array
     */
    public function toArray() {
        return $this->params;
    }

}
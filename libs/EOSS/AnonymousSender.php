<?php
/**
 * Created by PhpStorm.
 * User: juraj
 * Date: 12/2/16
 * Time: 3:42 PM
 */

namespace EOSS;


class AnonymousSender
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
            throw new \Exception("Can't find the parameter {$key} inside anonymous sender.");
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
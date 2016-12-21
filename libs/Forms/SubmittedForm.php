<?php
/**
 * Created by PhpStorm.
 * User: juraj
 * Date: 12/1/16
 * Time: 4:04 PM
 */

namespace Forms;

/**
 * Received when the form is submitted as argument to the event.
 *
 * @author Juraj Čarnogurský
 * Class SubmittedForm
 * @package Forms
 */
class SubmittedForm
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
            throw new \Exception("Can't find the parameter {$key} inside Registry.");
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

}
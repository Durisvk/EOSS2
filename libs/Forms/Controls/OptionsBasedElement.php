<?php
/**
 * Created by PhpStorm.
 * User: juraj
 * Date: 12/1/16
 * Time: 6:42 PM
 */

namespace Forms\Controls;


abstract class OptionsBasedElement extends BaseElement
{

    /**
     * @var array
     */
    private $options = array();


    /**
     * OptionsBasedElement constructor.
     * @param string $name
     * @param string $label
     * @param string $id
     * @param array $options
     */
    public function __construct($name, $label = "", $id = "", array $options = array())
    {
        parent::__construct($name, $label, $id);
        $this->options = $options;
    }

    /**
     * Adds the option to the element.
     * @param string $value
     * @param string $text
     * @return $this
     */
    public function addOption($value, $text) {
        $this->options[$value] = $text;
        return $this;
    }

    /**
     * Adds the options to the element.
     * @param $array
     * @return $this
     */
    public function addOptions($array) {
        foreach($array as $key => $value) {
            $this->options[$key] = $value;
        }
        return $this;
    }

    /**
     * Sets the options as array[value] = text.
     * @param array $array
     * @return $this
     */
    public function setOptions(array $array) {
        $this->options = $array;
        return $this;
    }

    /**
     * Gets the option's text.
     * @param string $value
     * @param bool $need
     * @return mixed|null
     * @throws \Exception
     */
    public function getOptionText($value, $need = FALSE) {
        if(isset($this->options[$value])) {
            return $this->options[$value];
        }

        if($need) {
            throw new \Exception("Option \"{$value}\" not found.");
        } else {
            return NULL;
        }
    }

    /**
     * Gets the options as associative array.
     * @return array
     */
    public function getOptions() {
        return $this->options;
    }

}
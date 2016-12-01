<?php

namespace Forms\Controls;


/**
 * Basic submit class.
 * Class Submit
 * @package Forms\Controls
 */
class Submit implements IElement
{

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $value;

    /**
     * @var string[]
     */
    private $attributes;


    /**
     * Submit constructor.
     * @param string $name
     * @param string $value
     */
    public function __construct($name, $value) {
        $this->name = $name;
        $this->value = $value;
    }


    /**
     * Returns the name of element.
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Gets the value of element.
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }


    /**
     * Adds an attribute to the element
     * @param string $attr
     * @param string $value
     * @return $this
     */
    public function addAttribute($attr, $value) {
        $this->attributes[$attr] = $value;
        return $this;
    }

    /**
     * Gets attributes.
     * @return \string[]
     */
    public function getAttributes() {
        return $this->attributes;
    }

    /**
     * Gets the attribute or null or fire exception if needed.
     * @param $name
     * @param bool $need
     * @return null|string
     * @throws \Exception
     */
    public function getAttribute($name, $need = FALSE) {
        if(isset($this->attributes[$name])) {
            return $this->attributes[$name];
        } else {
            if($need) {
                throw new \Exception("Attribute \"{$name}\" not found in class \"" . get_class() . "\"");
            } else {
                return NULL;
            }
        }
    }

    public function __toString()
    {
        return "<input type=\"submit\" name=\"{$this->name}\" data-ignore=\"true\" value=\"{$this->value}\" />";
    }


}
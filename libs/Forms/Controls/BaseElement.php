<?php

namespace Forms\Controls;


class BaseElement
{

    /**
     * @var bool
     */
    private $required = FALSE;


    /**
     * @var string[]
     */
    private $attributes = [];

    /**
     * Sets the element to required based on value.
     * @param bool $value
     * @return $this
     */
    public function setRequired($value = TRUE) {
        $this->required = $value;
        return $this;
    }

    /**
     * Returns if current element is required.
     * @return bool
     */
    public function isRequired() {
        return $this->required;
    }

    /**
     * Adds an attribute to the element
     * @param string $attr
     * @param string $value
     * @return BaseElement
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

    /**
     *
     * @return string
     */
    protected function getAttributesAsString() {
        if(count($this->attributes) == 0) {
            return "";
        }

        $str = "";
        foreach($this->attributes as $key => $value) {
            $str .= $key . "=\"{$value}\"";
            if(end($this->attributes) != $value) {
                $str .= " ";
            }
        }
        return $str;
    }

}
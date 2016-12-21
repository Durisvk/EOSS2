<?php

namespace Forms\Controls;

/**
 * BaseElement helper.
 *
 * @author Juraj Čarnogurský
 * Class BaseElement
 * @package Forms\Controls
 */
abstract class BaseElement
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
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $label = "";

    /**
     * @var string
     */
    private $id = "";

    /**
     * @var string
     */
    private $value = "";

    /**
     * BaseElement constructor.
     * @param string $name
     * @param string $label
     * @param string $id
     */
    public function __construct($name, $label = "", $id = "") {
        $this->name = $name;
        $this->label = $label;
        $this->id = $id;
        if($this->id == "") {
            $this->id = "form-" . $this->name . "-element";
        }
    }

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
     * Returns the name of element.
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Returns the element's label.
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
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
     * Sets the value of element.
     * @param string $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }



    /**
     * Returns the element's id.
     * @return string
     */
    public function getId()
    {
        return $this->id;
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
     * Returns formatted attributes.
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

    public function getLabelAsHtml() {
        if($this->label == "") {
            return "";
        }

        return "<label for=\"{$this->id}\">{$this->label}</label>";
    }

}
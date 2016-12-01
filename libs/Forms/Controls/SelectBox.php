<?php

namespace Forms\Controls;


class SelectBox extends OptionsBasedElement implements IElement
{

    /**
     * @var bool
     */
    private $multiple = FALSE;

    /**
     * @var array
     */
    private $values = [];


    /**
     * SelectBox constructor.
     * @param string $name
     * @param string $label
     * @param string $id
     * @param array $options
     * @param bool $multiple
     */
    public function __construct($name, $label, $id, array $options, $multiple = FALSE) {
        parent::__construct($name, $label, $id, $options);
        $this->multiple = $multiple;
    }

    /**
     * Sets the value for the selectbox.
     * @param string|array $value
     * @throws \Exception
     */
    public function setValue($value) {
        if($this->isMultiple()) {
            if(is_array($value)) {
                $this->values = $value;
            } else if(is_string($value)) {
                $this->values[] = $value;
            } else {
                throw new \Exception("Invalid value passed.");
            }
        } else {
            if(is_string($value)) {
                $this->values = [$value];
            } else {
                throw new \Exception("Invalid value passed.");
            }
        }
    }

    /**
     * Gets the value/s.
     * @return array
     */
    public function getValue() {
        return $this->values;
    }

    /**
     * If is multiple.
     * @return boolean
     */
    public function isMultiple()
    {
        return $this->multiple;
    }

    /**
     * Sets the multiple.
     * @param boolean $multiple
     * @return $this
     */
    public function setMultiple($multiple = TRUE)
    {
        $this->multiple = $multiple;
        return $this;
    }


    /**
     * Renders the element.
     * @return string
     */
    public function __toString() {
        $str = "<select name=\"{$this->getName()}" . ($this->multiple ? "[]" : "") . "\" id=\"{$this->getId()}\" data-ignore=\"true\" {$this->getAttributesAsString()}" . ($this->isRequired() ? " required" : ""). "" . ($this->multiple ? " multiple" : "") .">";

        foreach($this->getOptions() as $key => $value) {
            $str .= "<option value=\"{$key}\"" . (in_array($key, $this->values) ? " selected=\"selected\"" : "") . ">{$value}</option>";
        }

        $str .= "</select>";
        return $str;
    }


}
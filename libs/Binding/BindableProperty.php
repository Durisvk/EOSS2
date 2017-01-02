<?php

namespace Binding;

/**
 * Bindable property implementation.
 *
 * @author Juraj Čarnogurský
 * Class BindableProperty
 * @package Binding
 */
class BindableProperty implements IBindableProperty
{

    /**
     * @var mixed
     */
    private $element;

    /**
     * @var string
     */
    private $attribute;

    /**
     * @var mixed
     */
    private $value;

    public function __construct($value = NULL, $element = NULL, $attribute = NULL) {
        $this->value = $value;
        $this->element = $element;
        $this->attribute = $attribute;
    }

    /**
     * Sets the value and binds the element.
     * @param mixed $value
     */
    public function set($value)
    {
        if($this->element && $this->attribute) {
            if($this->element->{$this->attribute} instanceof BindedAttribute) {
                $this->element->{$this->attribute}->setWithoutBinding($value);
            } else {
                $this->element->{$this->attribute} = $value;
            }
        }
        $this->value = $value;
    }

    /**
     * Gets the value.
     * @return mixed
     */
    public function get()
    {
        return $this->value;
    }


}
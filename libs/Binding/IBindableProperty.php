<?php

namespace Binding;


/**
 * If the property is bounded to the element it should implement this interface.
 *
 * @author Juraj Čarnogurský
 * Interface IBindableProperty
 * @package Binding
 */
interface IBindableProperty
{

    /**
     * Sets the property value and binds the element.
     * @param mixed $value
     */
    public function set($value);

    /**
     * Gets the property value.
     * @return mixed
     */
    public function get();

}
<?php

namespace Binding;


/**
 * If attribute is bounded to the property it implements this interface.
 * Interface IBindedAttribute
 * @package Binding
 */
interface IBindedAttribute
{

    /**
     * Gets the value.
     * @return mixed
     */
    public function get();


    /**
     * Sets the value
     * @param mixed $value
     */
    public function set($value);

}
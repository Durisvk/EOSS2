<?php

namespace Binding;


/**
 * IBindable attribute implementation.
 *
 * @author Juraj Čarnogurský
 * Class BindedAttribute
 * @package Binding
 */
class BindedAttribute
{

    /**
     * @var object
     */
    private $obj;

    /**
     * @var string
     */
    private $key;

    /**
     * @var mixed
     */
    private $value;

    /**
     * BindedAttribute constructor.
     * @param mixed $value
     * @param object $obj
     * @param string $key
     */
    public function __construct($value = NULL, $obj, $key) {
        $this->value = $value;
        $this->obj = $obj;
        $this->key = $key;
    }

    /**
     * Sets the value to the attribute and updates the bounded property.
     * @param mixed $value
     * @throws \Exception
     */
    public function set($value) {
        if(property_exists($this->obj, $this->key)) {
            $reflector = new \ReflectionClass(get_class($this->obj));

            $prop = $reflector->getProperty($this->key);

            if ($prop->isPrivate() || $prop->isProtected()) {
                // Hack:
                $prop->setAccessible(TRUE);
                /** @var IBindableProperty $bindable */
                $bindable = $prop->getValue($this->obj);
                $bindable->set($value);
            } else {
                $this->obj->{$this->key}->set($value);
            }
        } else {
            throw new \Exception("Property cannot be binded, \"{$key}\" was not found.");
        }

        $this->value = $value;
    }

    /**
     * Sets the value without binding.
     * @param $value
     */
    public function setWithoutBinding($value) {
        $this->value = $value;
    }

    /**
     * Gets the value of an attribute.
     * @param $value
     * @return mixed|null
     */
    public function get($value) {
        return $this->value;
    }

}
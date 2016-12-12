<?php

namespace Binding;


class BindableCollection
{

    /**
     * @var array
     */
    private $value = [];

    /**
     * BindableCollection constructor.
     * @param array $value
     */
    public function __construct(array $value)
    {
        $this->value = $value;
    }

    /**
     * Adds the data to the collection.
     * @param array $data
     */
    public function add($data) {
        $this->value[] = $data;
    }

    /**
     * Removes the record from collection where $data[$attr] = $value.
     * @param string $attr
     * @param string $value
     */
    public function removeWhere($attr, $value) {
        $i = 0;
        foreach($this->value as $data) {
            if($data[$attr] == $value) {
                unset($this->value[$i]);
            }
            $i++;
        }
    }

    /** Gets the data from collection as array.
     * @return array
     */
    public function getValue()
    {
        return (array)$this->value;
    }

    /**
     * Sets the data to collection as array.
     * @param array $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }



}
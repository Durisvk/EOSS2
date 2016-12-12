<?php

namespace Binding;

/**
 * Serves for collection item source binding.
 * Interface IBindableCollection
 * @package Binding
 */
interface IBindableCollection
{
    /**
     * Adds the data to the collection.
     * @param array $data
     */
    public function add($data);

    /**
     * Removes data where $data[$attr] == $value.
     * @param string $attr
     * @param string $value
     */
    public function removeWhere($attr, $value);
}
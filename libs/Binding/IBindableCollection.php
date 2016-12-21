<?php

namespace Binding;

/**
 * Serves for collection item source binding.
 *
 * @author Juraj Čarnogurský
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
     * Removes first data where $data[$attr] == $value.
     * @param string $attr
     * @param string $value
     */
    public function removeFirstWhere($attr, $value);


    /**
     * Removes all data where $data[$attr] == $value.
     * @inheritdoc
     * @param string $attr
     * @param string $value
     */
    public function removeAllWhere($attr, $value);


    /**
     * Finds the first element where $data[$attr] == $value.
     * @inheritdoc
     * @param string $attr
     * @param string $value
     * @return array|null
     */
    public function findFirstWhere($attr, $value);

    /**
     * Finds all the elements where $data[$attr] == $value.
     * @param string $attr
     * @param string $value
     * @return array
     */
    public function findAllWhere($attr, $value);

    /**
     * Updates all of the elements where $data[$attr] == $value.
     * @param string $attr
     * @param mixed $value
     * @param string $attrToChange
     * @param mixed $changeValue
     */
    public function updateAllWhere($attr, $value, $attrToChange, $changeValue);

    /**
     * Updates first element where $data[$attr] == $value.
     * @inheritdoc
     * @param string $attr
     * @param mixed $value
     * @param string $attrToChange
     * @param mixed $changeValue
     */
    public function updateFirstWhere($attr, $value, $attrToChange, $changeValue);

    /**
     * Sets the collection value.
     * @param array $value
     * @return mixed
     */
    public function setValue(array $value);
}
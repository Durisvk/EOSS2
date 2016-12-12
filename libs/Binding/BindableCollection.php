<?php

namespace Binding;

/**
 * Collection that is bound to an element.
 * Class BindableCollection
 * @package Binding
 */
class BindableCollection implements IBindableCollection
{

    /**
     * @var array
     */
    private $value = [];

    private $element = NULL;

    private $binding = NULL;

    /**
     * BindableCollection constructor.
     * @param array $value
     * @param CollectionBinding $binding
     * @param null|object $element
     */
    public function __construct(array $value, CollectionBinding $binding, $element = NULL)
    {
        $this->value = $value;
        $this->element = $element;
        $this->binding = $binding;
    }

    /**
     * @inheritdoc
     */
    public function add($data) {
        $this->value[] = $data;
        $this->updateElement();
    }

    /**
     * @inheritdoc
     */
    public function removeFirstWhere($attr, $value) {
        $i = 0;
        foreach($this->value as $data) {
            if($data[$attr] == $value) {
                unset($this->value[$i]);
                $this->updateElement();
                return;
            }
            $i++;
        }
    }

    /**
     * @inheritdoc
     */
    public function removeAllWhere($attr, $value) {
        $i = 0;
        foreach($this->value as $data) {
            if($data[$attr] == $value) {
                unset($this->value[$i]);
            }
            $i++;
        }

        $this->updateElement();
    }

    /**
     * @inheritdoc
     */
    public function findFirstWhere($attr, $value) {
        foreach($this->value as $data) {
            if($data[$attr] == $value) {
                return $data;
            }
        }
        return NULL;
    }

    /**
     * @inheritdoc
     */
    public function findAllWhere($attr, $value) {
        $array = [];
        foreach($this->value as $data) {
            if($data[$attr] == $value) {
                $array[] = $data;
            }
        }
        return $array;
    }

    /**
     * @inheritdoc
     */
    public function updateAllWhere($attr, $value, $attrToChange, $changeValue) {
        $i = 0;
        foreach($this->value as $data) {
            if($data[$attr] == $value) {
                $this->value[$i][$attrToChange] = $changeValue;
            }
            $i++;
        }
        $this->updateElement();
    }


    /**
     * @inheritdoc
     */
    public function updateFirstWhere($attr, $value, $attrToChange, $changeValue) {
        $i = 0;
        foreach($this->value as $data) {
            if($data[$attr] == $value) {
                $this->value[$i][$attrToChange] = $changeValue;
                $this->updateElement();
                return;
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
        $this->updateElement();
    }


    /**
     * Updates the bounded element's html.
     */
    public function updateElement() {
        if($this->element) {
            $this->element->html = $this->binding->injectIntoTemplate($this->value);
        }
    }



}
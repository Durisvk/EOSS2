<?php

use \Binding\IBindableProperty;

class ExampleModel
{

    /**
     * @var IBindableProperty
     */
    private $range;

    /**
     * @return int
     */
    public function getRange()
    {
        return $this->range->get();
    }

    /**
     * @param int $range
     */
    public function setRange($range)
    {
        $this->range->set($range);
    }



}
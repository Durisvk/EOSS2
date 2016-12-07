<?php

class ExampleModel
{

    /**
     * @var int
     */
    private $range;

    /**
     * @return int
     */
    public function getRange()
    {
        return $this->range;
    }

    /**
     * @param int $range
     */
    public function setRange($range)
    {
        $this->range = $range;
    }



}
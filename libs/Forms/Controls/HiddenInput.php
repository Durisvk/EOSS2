<?php

namespace Forms\Controls;


/**
 * Basic hidden input.
 * Class HiddenInput
 * @package Forms\Controls
 */
class HiddenInput implements IElement
{

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $value = "";

    /**
     * @var string
     */
    private $id = "";

    /**
     * Hidden constructor.
     * @param string $name
     * @param string $value
     * @param string $id
     */
    public function __construct($name, $value = "", $id = "") {
        $this->name = $name;
        $this->value = $value;
        $this->id = $id;
    }


    /**
     * Gets the name of hidden element.
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Gets the value of hidden element.
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Sets the value of hidden element.
     * @param string $value
     * @return $this
     */
    public function setValue($value) {
        $this->value = $value;
        return $this;
    }

    public function getId() {
        return $this->id;
    }

    /**
     * Renders the element.
     * @return string
     */
    public function __toString() {
        return "<input name=\"{$this->name}\"" . ($this->id == "" ? "" : " id=\"{$this->id}\"") . " type=\"hidden\" data-ignore=\"true\" " . ($this->getValue() == "" ? "" : "value=\"{$this->getValue()}\"") . "/>";
    }

}
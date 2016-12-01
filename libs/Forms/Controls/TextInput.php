<?php

namespace Forms\Controls;


/**
 * Basic input class.
 * Class TextInput
 * @package Forms\Controls
 */
class TextInput extends BaseElement implements IElement
{

    const TYPE_TEXT = "text";
    const TYPE_NUMBER = "number";
    const TYPE_EMAIL = "email";
    const TYPE_PASSWORD = "password";

    /**
     * @var string
     */
    private $type = self::TYPE_TEXT;


    /**
     * Sets the input type.
     * @param string $type
     * @return $this
     */
    public function setType($type) {
        $this->type = $type;
        return $this;
    }


    /**
     * Gets the input type.
     * @return string
     */
    public function getType() {
        return $this->type;
    }

    /**
     * Renders the element.
     * @return string
     */
    public function __toString() {
        return "<input name=\"{$this->getName()}\" id=\"{$this->getId()}\" type=\"{$this->type}\" data-ignore=\"true\" " . ($this->getValue() == "" ? "" : "value=\"{$this->getValue()}\"") . " {$this->getAttributesAsString()}" . ($this->isRequired() ? " required" : ""). "/>";
    }


}
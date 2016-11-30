<?php

namespace Forms\Controls;



class TextInput extends BaseElement implements IElement
{

    const TYPE_TEXT = "text";
    const TYPE_NUMBER = "number";
    const TYPE_EMAIL = "email";

    /**
     * @var string
     */
    private $type = self::TYPE_TEXT;

    /**
     * @var string
     */
    private $name;

    /**
     * TextInput constructor.
     * @param string $name
     */
    public function __construct($name) {
        $this->name = $name;
    }

    /**
     * Renders the element.
     * @return string
     */
    public function __toString() {
        return "<input name=\"{$this->name}\" type=\"{$this->type}\" {$this->getAttributesAsString()}" . ($this->isRequired() ? " required" : ""). "/>";
    }


}
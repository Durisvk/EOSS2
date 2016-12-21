<?php

namespace Forms\Controls;


/**
 * Basic textarea class.
 *
 * @author Juraj Čarnogurský
 * Class TextArea
 * @package Forms\Controls
 */
class TextArea extends BaseElement implements IElement
{

    /**
     * Renders the textarea.
     * @return string
     */
    public function __toString()
    {
        return "<textarea name=\"{$this->getName()}\" data-ignore=\"true\" id=\"{$this->getId()}\" {$this->getAttributesAsString()} " . ($this->isRequired() ? " required" : ""). ">{$this->getValue()}</textarea>";
    }


}
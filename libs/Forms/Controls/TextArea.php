<?php

namespace Forms\Controls;


class TextArea extends BaseElement implements IElement
{
    public function __toString()
    {
        return "<textarea name=\"{$this->getName()}\" data-ignore=\"true\" id=\"{$this->getId()}\" {$this->getAttributesAsString()} " . ($this->isRequired() ? " required" : ""). ">{$this->getValue()}</textarea>";
    }


}
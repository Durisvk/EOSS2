<?php

namespace Forms\Controls;

/**
 * Basic file input.
 * Class FileInput
 * @package Forms\Controls
 */
class FileInput extends BaseElement implements IElement
{

    /**
     * @var bool
     */
    private $multiple = FALSE;

    /**
     * FileInput constructor.
     * @param string $name
     * @param bool $multiple
     * @param string $label
     * @param string $id
     */
    public function __construct($name, $multiple = FALSE,$label = "", $id = "")
    {
        parent::__construct($name, $label, $id);
        $this->multiple = $multiple;
    }

    /**
     * Renders the file element.
     * @return string
     */
    public function __toString() {
        $str = "<input name=\"{$this->getName()}" . ($this->multiple ? "[]" : "") . "\" id=\"{$this->getId()}\" type=\"file\" data-ignore=\"true\" {$this->getAttributesAsString()}" . ($this->isRequired() ? " required" : ""). " " . ($this->multiple ? "multiple" : "") . "/>";

        if($this->getValue() != "") {
            $str .= "<a href=\"{$this->getValue()}\" download>{$this->getValue()}</a>";
        }

        return $str;
    }

    /**
     * If is multiple.
     * @return bool
     */
    public function isMultiple() {
        return $this->multiple;
    }

    /**
     * Sets the file field to allow multiple files.
     * @param bool $value
     * @return $this
     */
    public function setMultiple($value = TRUE) {
        $this->multiple = $value;
        return $this;
    }

}
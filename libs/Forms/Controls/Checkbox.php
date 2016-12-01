<?php
/**
 * Created by PhpStorm.
 * User: juraj
 * Date: 12/1/16
 * Time: 5:08 PM
 */

namespace Forms\Controls;


/**
 * Basic checkbox.
 * Class Checkbox
 * @package Forms\Controls
 */
class Checkbox extends BaseElement implements IElement
{

    /**
     * @var bool
     */
    private $checked = FALSE;

    /**
     * Sets the checkbox to be checked.
     * @param bool $value
     * @return $this
     */
    public function setChecked($value = TRUE) {
        $this->checked = $value;
        return $this;
    }

    /**
     * If is checkbox checked.
     * @return bool
     */
    public function isChecked() {
        return $this->checked;
    }

    /**
     * Renders the element.
     * @return string
     */
    public function __toString() {
        return "<input name=\"{$this->getName()}\" id=\"{$this->getId()}\" type=\"checkbox\" data-ignore=\"true\" {$this->getAttributesAsString()}" . ($this->isRequired() ? " required" : ""). ($this->checked ? " checked=\"checked\"" : "") . "/>";
    }


}
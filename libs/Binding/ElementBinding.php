<?php

namespace Binding;

/**
 * Takes care of element to element binding.
 *
 * @author Juraj Čarnogurský
 * Class ElementBinding
 * @package Binding
 */
class ElementBinding
{

    /**
     * @var string
     */
    private $sourceElement;

    /**
     * @var string
     */
    private $sourceAttribute;

    /**
     * @var string
     */
    private $targetAttribute;


    /**
     * @var string
     */
    private $string;


    /**
     * @var string
     */
    private $mode;

    /**
     * @var string|null
     */
    private $element;

    /**
     * ElementBinding constructor.
     * @param string $sourceElement
     * @param string $sourceAttribute
     * @param string $targetAttribute
     * @param string $mode
     * @param string $string
     * @param array|null $element
     */
    public function __construct($sourceElement, $sourceAttribute, $targetAttribute, $mode,$string, $element = NULL) {

        $this->sourceElement = $sourceElement;
        $this->sourceAttribute = $sourceAttribute;
        $this->targetAttribute = $targetAttribute;
        $this->string = $string;
        $this->mode = $mode;
        $this->element = $element["id"];
    }

    /**
     * Returns the source elements selector.
     * @return string
     */
    public function getSourceElement()
    {
        return $this->sourceElement;
    }

    /**
     * Returns the source elements attribute to bind to.
     * @return string
     */
    public function getSourceAttribute()
    {
        return $this->sourceAttribute;
    }

    /**
     * Returns the target attribute of element that should be bind.
     * @return string
     */
    public function getTargetAttribute()
    {
        return $this->targetAttribute;
    }

    /**
     * Returns the data-binding string.
     * @return string
     */
    public function getString()
    {
        return $this->string;
    }

    /**
     * Returns the binding mode.
     * @return string
     */
    public function getMode() {
        return $this->mode;
    }

    /**
     * Returns the target element.
     * @return null|string
     */
    public function getElement() {
        return $this->element;
    }


    /**
     * Returns the javascript action.
     * @return string
     */
    public function getJavascriptAction() {
        $js = "$( '{$this->getSourceElement()}' ).";
        if($this->getSourceAttribute() == 'html') {
            $js .= "html({$this->getJavascriptValue()});";
        } else if($this->getSourceAttribute() == 'value') {
            $js .= "val({$this->getJavascriptValue()});";
        } else {
            $js .= "attr(\"{$this->getSourceAttribute()}\", {$this->getJavascriptValue()});";
        }
        return $js;
    }

    /**
     * Returns javascript value
     * @return string
     */
    private function getJavascriptValue() {
        $js = "$(this).";
        if($this->getTargetAttribute() == 'html') {
            $js .= "html()";
        } else if($this->getTargetAttribute() == 'value') {
            $js .= "val()";
        } else {
            $js .= "attr(\"{$this->getTargetAttribute()}\")";
        }
        return $js;
    }

    /**
     * Gets the second way of binding as javascript.
     * @return string
     */
    public function getJavascriptSecondWay() {
        if($this->mode != 'two-way') {
            return "";
        }

        $js = "$( \"" . ($this->getElement() ? "#" . $this->getElement() : "[data-binding = \\\"{$this->getString()}\\\"]") . "\" ).";
        if($this->getTargetAttribute() == 'html') {
            $js .= "html({$this->getJavascriptValueSecondWay()});";
        } else if($this->getTargetAttribute() == 'value') {
            $js .= "val({$this->getJavascriptValueSecondWay()});";
        } else {
            $js .= "attr(\"{$this->getTargetAttribute()}\", {$this->getJavascriptValueSecondWay()});";
        }
        return $js;
    }

    /**
     * Gets the value of binding as javascript.
     * @return string
     */
    private function getJavascriptValueSecondWay() {
        $js = "$(this).";
        if($this->getSourceAttribute() == 'html') {
            $js .= "html()";
        } else if($this->getSourceAttribute() == 'value') {
            $js .= "val()";
        } else {
            $js .= "attr(\"{$this->getSourceAttribute()}\")";
        }
        return $js;
    }


    /**
     * Initial element to element binding.
     * @return string
     */
    public function initialBindingJavascript() {
        $js = "$( '{$this->getSourceElement()}' ).";
        if($this->getSourceAttribute() == 'html') {
            $js .= "html(";
        } else if($this->getSourceAttribute() == 'value') {
            $js .= "val(";
        } else {
            $js .= "attr(\"{$this->getSourceAttribute()}\", ";
        }
        $js .= "$( \"" . ($this->getElement() ? "#" . $this->getElement() : "[data-binding = \\\"{$this->getString()}\\\"]") . "\" ).";

        if($this->getTargetAttribute() == 'html') {
            $js .= "html()";
        } else if($this->getTargetAttribute() == 'value') {
            $js .= "val()";
        } else {
            $js .= "attr(\"{$this->getTargetAttribute()}\")";
        }

        $js .= ");\n";

        return $js;
    }




}
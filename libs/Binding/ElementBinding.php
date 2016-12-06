<?php

namespace Binding;


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


    private $string;

    /**
     * ElementBinding constructor.
     * @param string $sourceElement
     * @param string $sourceAttribute
     * @param string $targetAttribute
     * @param string $string
     */
    public function __construct($sourceElement, $sourceAttribute, $targetAttribute, $string) {

        $this->sourceElement = $sourceElement;
        $this->sourceAttribute = $sourceAttribute;
        $this->targetAttribute = $targetAttribute;
        $this->string = $string;

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




}
<?php
/**
 * Created by PhpStorm.
 * User: juraj
 * Date: 12/1/16
 * Time: 6:38 PM
 */

namespace Forms\Controls;


/**
 * Basic radio list class.
 * Class RadioList
 * @package Forms\Controls
 */
class RadioList extends OptionsBasedElement implements IElement
{




    /**
     * Renders the element.
     * @return string
     */
    public function __toString()
    {
        $str = "";
        $i = 1;
        foreach($this->getOptions() as $key => $value) {
            $str .= "<input type=\"radio\" name=\"{$this->getName()}\" id=\"" . $this->getId() . "-" . $i . "\" value=\"{$key}\"" . ($this->getValue() == $key ? " checked=\"checked\"" : "") . " data-ignore=\"true\" {$this->getAttributesAsString()}" . ($this->isRequired() ? " required" : ""). "/>";
            $str .= "<label for=\"" . $this->getId() . "-" . $i . "\">{$value}</label><br>";
            $i++;
        }
        return $str;
    }


}
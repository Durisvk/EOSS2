<?php


namespace Forms;


use EOSS\EOSS;
use Forms\Controls\IElement;

/**
 * Basic form wrapper.
 * Class Form
 * @package Forms
 */
class Form implements IElement
{

    /**
     * Available methods:
     */
    const METHOD_GET = "get";
    const METHOD_POST = "post";


    /**
     * Accepts the string as the method name of current EOSS.
     * @var array
     */
    public $onsubmit = array();

    /**
     * @var string
     */
    private $action = URL_LIBS . "request.php";

    /**
     * @var string
     */
    private $method = self::METHOD_GET;


    /**
     * @var IElement[]
     */
    private $components = array();

    /**
     * Form constructor. If EOSS is passed in the form is automatically registered.
     * @param EOSS|NULL $eoss
     */
    public function __construct(EOSS $eoss = NULL) {
        if($eoss) {
            $eoss->registerForm($this);
        }
    }


    /**
     * Renders the form.
     * @return string
     */
    public function __toString() {
        $str = "<form action=\"{$this->action}\" method=\"{$this->method}\">";

        foreach($this->components as $component) {
            $str .= $component;
        }

        $str .= "</form>";

        return $str;
    }

    /**
     * Adds the component into form.
     * @param IElement $element
     */
    public function addComponent(IElement $element) {
        $this->components[] = $element;
    }

    /**
     * Gets the components of a form.
     * @return Controls\IElement[]
     */
    public function getComponents() {
        return $this->components;
    }

}
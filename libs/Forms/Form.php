<?php


namespace Forms;


use EOSS\EOSS;
use Forms\Controls\BaseElement;
use Forms\Controls\IElement;
use Forms\Controls\Submit;
use Forms\Controls\TextArea;
use Forms\Controls\TextInput;

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
    private $action = "request.php";

    /**
     * @var string
     */
    private $method = self::METHOD_POST;


    /**
     * @var IElement[]|BaseElement[]
     */
    private $components = array();

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $id;

    /**
     * Form constructor. If EOSS is passed in the form is automatically registered.
     * @param string $name
     * @param EOSS|NULL $eoss
     * @param string $id
     */
    public function __construct($name, EOSS $eoss = NULL, $id = "") {
        if($eoss) {
            $eoss->registerForm($this);
        }

        $this->name = $name;
        $this->id = $id;

        if($this->id == "") {
            $this->id = $this->name . "-form";
        }
        $this->action = URL_LIBS . "request.php";
    }


    /**
     * Renders the form.
     * @return string
     */
    public function __toString() {
        $str = $this->openTag();
        foreach($this->components as $component) {
            if($component instanceof BaseElement) {
                $str .= $component->getLabelAsHtml();
            }
            $str .= $component;
            $str .= "<br>";
        }

        $str .= "</form>";

        return $str;
    }

    /**
     * Renders a Form as table.
     * @return string
     */
    public function asTable() {
        $str = $this->openTag();

        $str .= "<table>";
        foreach($this->components as $component) {
            $str .= "<tr>";
            $str .= "<td>";
            if($component instanceof BaseElement) {
                $str .= $component->getLabelAsHtml();
            }
            $str .= "</td>";
            $str .= "<td>";
            $str .= $component;
            $str .= "</td>";
            $str .= "</tr>";
        }
        $str .= "</table>";

        $str .= "</form>";

        return $str;
    }

    /**
     * Opens the form tag.
     * @return string
     */
    private function openTag() {
        return "<form action=\"{$this->action}\" method=\"{$this->method}\" data-ignore=\"true\" id=\"{$this->id}\">";
    }

    /**
     * Gets the form id.
     * @return string
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Gets the form name.
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Adds the component into form.
     * @param IElement $element
     * @return IElement|BaseElement
     */
    public function addComponent(IElement $element) {
        $this->components[] = $element;
        return $element;
    }

    /**
     * Gets the components of a form.
     * @return IElement[]|BaseElement[]
     */
    public function getComponents() {
        return $this->components;
    }

    /**
     * Adds the TextInput element to the form.
     * @param string $name
     * @param string $label
     * @param string $id
     * @return TextInput
     */
    public function addText($name, $label = "", $id = "") {
        $input = new TextInput($name, $label, $id);
        $this->addComponent($input);
        return $input;
    }

    /**
     * Adds the password element to the form.
     * @param string $name
     * @param string $label
     * @param string $id
     * @return TextInput
     */
    public function addPassword($name, $label = "", $id = "") {
        $input = new TextInput($name, $label, $id);
        $input->setType(TextInput::TYPE_PASSWORD);
        $this->addComponent($input);
        return $input;
    }

    public function addTextArea($name, $label = "", $id ="", $cols = NULL, $rows = NULL) {
        $textarea = new TextArea($name, $label, $id);
        if($cols) {
            $textarea->addAttribute("cols", $cols);
        }
        if($rows) {
            $textarea->addAttribute("rows", $rows);
        }
        $this->addComponent($textarea);
        return $textarea;
    }

    public function addSubmit($name, $value) {
        $submit = new Submit($name, $value);
        $this->addComponent($submit);
        return $submit;
    }

}
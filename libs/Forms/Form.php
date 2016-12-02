<?php


namespace Forms;


use Debug\Linda;
use EOSS\EOSS;
use Forms\Controls\BaseElement;
use Forms\Controls\Checkbox;
use Forms\Controls\FileInput;
use Forms\Controls\HiddenInput;
use Forms\Controls\IElement;
use Forms\Controls\RadioList;
use Forms\Controls\SelectBox;
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
     * @var bool
     */
    private $file = FALSE;

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


    public function asRaw() {
        $str = $this->openTag();
        foreach($this->components as $component) {
            if($component instanceof BaseElement) {
                $str .= $component->getLabelAsHtml();
            }
            $str .= $component;
        }

        $str .= "</form>";

        return $str;
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
            if(!$component instanceof HiddenInput) {
                $str .= "<br>";
            }
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
            if(!$component instanceof HiddenInput) {
                $str .= "<tr>";
                $str .= "<td>";
                if ($component instanceof BaseElement) {
                    $str .= $component->getLabelAsHtml();
                }
                $str .= "</td>";
                $str .= "<td>";
                $str .= $component;
                $str .= "</td>";
                $str .= "</tr>";
            } else {
                $str .= $component;
            }
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
        return "<form action=\"{$this->action}\" method=\"{$this->method}\" data-ignore=\"true\" id=\"{$this->id}\" " . ($this->containsFile() ? "enctype=\"multipart/form-data\"" : "") . " >";
    }

    /**
     * Sets the form to use file.
     * @param bool $value
     */
    public function setContainsFile($value = TRUE) {
        $this->file = $value;
    }

    /**
     * If form contains file.
     * @return bool
     */
    public function containsFile() {
        return $this->file;
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
     * @param string $name
     * @param IElement $element
     * @return IElement|BaseElement
     */
    public function addComponent($name, IElement $element) {
        $this->components[$name] = $element;
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
        $this->addComponent($name, $input);
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
        $this->addComponent($name, $input);
        return $input;
    }


    /**
     * Adds the number element to the form.
     * @param string $name
     * @param string $label
     * @param string $id
     * @return TextInput
     */
    public function addNumber($name, $label = "", $id = "") {
        $input = new TextInput($name, $label, $id);
        $input->setType(TextInput::TYPE_NUMBER);
        $this->addComponent($name, $input);
        return $input;
    }

    /**
     * Adds the email element to the form.
     * @param string $name
     * @param string $label
     * @param string $id
     * @return TextInput
     */
    public function addEmail($name, $label = "", $id = "") {
        $input = new TextInput($name, $label, $id);
        $input->setType(TextInput::TYPE_EMAIL);
        $this->addComponent($name, $input);
        return $input;
    }

    /**
     * Adds the textarea element to the form.
     * @param string $name
     * @param string $label
     * @param string $id
     * @param null|number $cols
     * @param null|number $rows
     * @return TextArea
     */
    public function addTextArea($name, $label = "", $id ="", $cols = NULL, $rows = NULL) {
        $textarea = new TextArea($name, $label, $id);
        if($cols) {
            $textarea->addAttribute("cols", $cols);
        }
        if($rows) {
            $textarea->addAttribute("rows", $rows);
        }
        $this->addComponent($name, $textarea);
        return $textarea;
    }

    /**
     * Adds the select box into the form.
     * @param string $name
     * @param string $label
     * @param string $id
     * @param array $options
     * @param bool $multiple
     * @return SelectBox
     */
    public function addSelect($name, $label = "", $id = "", array $options = array(), $multiple = FALSE) {
        $select = new SelectBox($name, $label, $id, $options,$multiple);
        $select->setOptions($options);
        $this->addComponent($name, $select);
        return $select;
    }

    /**
     * Adds the checkbox into the form.
     * @param string $name
     * @param string $label
     * @param string $id
     * @return Checkbox
     */
    public function addCheckbox($name, $label = "", $id = "") {
        $checkbox = new Checkbox($name, $label, $id);
        $this->addComponent($name, $checkbox);
        return $checkbox;
    }

    /**
     * Adds the hidden input element.
     * @param string $name
     * @param string $value
     * @param string $id
     * @return HiddenInput
     */
    public function addHidden($name, $value = "", $id = "") {
        $hidden = new HiddenInput($name, $value, $id);
        $this->addComponent($name, $hidden);
        return $hidden;
    }

    /**
     * Adds the radio list element into the form.
     * @param string $name
     * @param string $label
     * @param string $id
     * @param array $options
     * @return RadioList
     */
    public function addRadioList($name, $label = "", $id = "", array $options = array()) {
        $radio = new RadioList($name, $label, $id, $options);
        $this->addComponent($name, $radio);
        return $radio;
    }

    /**
     * Adds the file input element.
     * @param string $name
     * @param bool $multiple
     * @param string $label
     * @param string $id
     * @return FileInput
     */
    public function addFile($name, $multiple = FALSE, $label = "", $id = "") {
        $file = new FileInput($name, $multiple, $label, $id);
        $this->addComponent($name, $file);
        $this->setContainsFile();
        return $file;
    }

    /**
     * Adds the submit button to the form.
     * @param string $name
     * @param string $value
     * @return Submit
     */
    public function addSubmit($name, $value) {
        $submit = new Submit($name, $value);
        $this->addComponent($name, $submit);
        return $submit;
    }



    public function setDefaults($data) {


        if ($data instanceof \Traversable) {
            $data = iterator_to_array($data);
        } else if (!is_array($data)) {
            throw new \Exception(sprintf('Parameter must be an array, "' . gettype($values) . '" given.'));
        }

        /**
         * @var string $name
         * @var IElement|BaseElement $control
         */
        foreach ($this->getComponents() as $name => $control) {
            if(array_key_exists($name, $data)) {

                if($control instanceof Checkbox) {
                    if(strtolower($data[$name]) == "on") {
                        $data[$name] = TRUE;
                    } else if(strtolower($data[$name]) == "off") {
                        $data[$name] = FALSE;
                    }
                    $control->setChecked($data[$name]);
                } else if($control instanceof BaseElement || $control instanceof HiddenInput) {
                    $control->setValue($data[$name]);
                }

            }
        }
        return $this;
    }

}
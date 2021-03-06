<?php

namespace Binding;


use Application\Config;
use Debug\Linda;
use EOSS\EOSS;
use Templating\TemplateFactory;
use Utils\HTML;

/**
 * Makes the collection binding work.
 *
 * @author Juraj Čarnogurský
 * Class CollectionBinding
 * @package Binding
 */
class CollectionBinding
{

    /**
     * @var string
     */
    private $itemSourcePath;

    /**
     * @var string
     */
    private $template;

    /**
     * @var string
     */
    private $itemTemplateFilePath;

    /**
     * @var string
     */
    private $string;

    /**
     * @var string
     */
    private $element;

    /**
     * Sets the property value.
     * @param EOSS $eoss
     * @param string $sourcePath
     * @param mixed $value
     * @throws \Exception
     */
    public static function setValue(EOSS $eoss, $sourcePath, $value) {

        $array = PropertyBinding::getObjectByPath($eoss, $sourcePath);

        $obj = $array["object"];
        $key = $array["key"];

        if(property_exists($obj, $key)) {
            $reflector = new \ReflectionClass(get_class($obj));

            $prop = $reflector->getProperty($key);

            if ($prop->isPrivate() || $prop->isProtected()) {
                if(method_exists($obj, "set".ucfirst($key))) {
                    $method = "set" . ucfirst($key);
                    $obj->$method($value);
                } else {
                    throw new \Exception("Property \"{$key}\" is inaccessible.");
                }
            } else {
                if($obj->{$key} instanceof BindableCollection) {
                    $obj->{$key}->setValue($value);
                } else {
                    $obj->{$key} = $value;
                }
            }
        } else {
            throw new \Exception("Property cannot be binded, \"{$key}\" was not found.");
        }
    }


    /**
     * Gets the property value.
     * @param EOSS $eoss
     * @param string $sourcePath
     * @return mixed|null
     * @throws \Exception
     */
    public static function getValue(EOSS $eoss, $sourcePath) {

        $array = PropertyBinding::getObjectByPath($eoss, $sourcePath);

        $obj = $array["object"];
        $key = $array["key"];

        $val = NULL;

        if(property_exists($obj, $key)) {
            $reflector = new \ReflectionClass(get_class($obj));

            $prop = $reflector->getProperty($key);

            if ($prop->isPrivate() || $prop->isProtected()) {
                if(method_exists($obj, "get".ucfirst($key))) {
                    $method = "get" . ucfirst($key);
                    $val = $obj->$method();
                } else {
                    throw new \Exception("Property \"{$key}\" is inaccessible.");
                }
            } else {
                $val = $obj->{$key};
            }
        } else {
            throw new \Exception("Property cannot be binded, \"{$key}\" was not found.");
        }

        return $val;
    }

    /**
     * CollectionBinding constructor.
     * @param string $itemSourcePath
     * @param string $template
     * @param string $string
     * @param string $itemTemplateFilePath
     * @param null|array $element
     */
    public function __construct($itemSourcePath, $template, $string, $itemTemplateFilePath = NULL, $element = NULL) {
        $this->itemSourcePath = $itemSourcePath;
        $this->template = $template;
        $this->string = $string;
        $this->itemTemplateFilePath = $itemTemplateFilePath;
        $this->element = $element["id"];
    }

    /**
     * Inserts the data into template
     * @param $array
     * @return mixed|string
     * @throws \Exception
     */
    public function injectIntoTemplate($array) {
        $str = "";
        if($this->itemTemplateFilePath) {
            $dir = DIR_APP . Config::getParam("layout_dir").$this->itemTemplateFilePath;
            if(!file_exists($dir)) {
                throw new \Exception("Error in setFile(\"" . $this->itemTemplateFilePath . "\"). File doesn't exist.");
            }
            $file = $dir;
            foreach($array as $data) {
                if($templateWrapper = TemplateFactory::create($file)) {
                    $templateWrapper->initialize();
                    $rf = $templateWrapper->render($file, $data);
                } else {
                    $rf = get_include_contents($file, $data);
                }
                $str .= $rf;
            }
        } else {
            $dom = new \DOMDocument();
            libxml_use_internal_errors(true);
            $dom->loadHTML($this->template, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
            libxml_clear_errors();
            foreach ($array as $data) {
                foreach ($data as $key => $value) {
                    /** @var \DOMNode $element */
                    foreach (HTML::getElementsByAttributeValue($dom, "data-key", $key) as $element) {
                        $element->nodeValue = $value;
                    }
                }
                $str .= $dom->saveHTML();
                foreach ($data as $key => $value) {
                    $str = preg_replace('/\(\* *' . $key . ' *\*\)/', $value, $str);
                }
            }

        }
        $str = str_replace("\"", "\\\"", $str);
        return $str;
    }

    /**
     * @return string
     */
    public function getElement()
    {
        return $this->element;
    }


    /**
     * @return string
     */
    public function getItemSourcePath()
    {
        return $this->itemSourcePath;
    }

    /**
     * @return string
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * @return string
     */
    public function getString()
    {
        return $this->string;
    }

    /**
     * Gets the javascript to process the collection binding.
     * @param EOSS $eoss
     * @return string
     */
    public function getJavascript(EOSS $eoss) {
        if($val = self::getValue($eoss, $this->getItemSourcePath())) {
            $array = $val;
            if($val instanceof BindableCollection) {
                $array = $val->getValue();
            }
            $js = "\n$( \"" . ($this->getElement() ? "#".$this->getElement() : "[data-binding=\\\"{$this->getString()}\\\"]") . "\" ).";
            $html = $this->injectIntoTemplate($array);
            $html = str_replace("\n", "", $html);
            $js .= "html( \"" . $html . "\" )\n.attr(\"data-collection\", '" . str_replace("'", "&quot;", json_encode(array_values($array))) . "');\n";

            return $js;
        }

        return "";
    }

}
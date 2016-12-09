<?php

namespace EOSS;


use Binding\ElementBinding;
use Binding\PropertyBinding;
use Debug\Linda;
use Templating\TemplateFactory;
use Utils\CSIHelper;
use Utils\HTML;
use Utils\JSON;


/**
 * Analyzes the DOM structure of view and generates the php files with that structure.
 * Class CSIAnalyze
 * @package EOSS
 */
class CSIAnalyze
{

    /**
     * @var string
     */
    private $file;

    /**
     * @var string
     */
    private $eossClassName;

    /**
     * @var CSI
     */
    private $csi;

    /**
     * CSIAnalyze constructor.
     * @param string $csi_file
     * @param string $eossClassName
     * @param CSI $csi
     * @throws \Exception
     */
    public function __construct($csi_file, $eossClassName, CSI $csi)
    {
        $this->csi = $csi;
        $this->eossClassName = $eossClassName;
        $dir = DIR_APP . \Application\Config::getParam("layout_dir").$csi_file;
        if(!file_exists($dir)) {
            throw new \Exception("Error in setFile(\"" . $csi_file . "\"). File doesn't exist.");
        }
        $this->file = $dir;
        $this->analyzeCsi();
    }

    /**
     * Analyzes the HTML file and generates CSI.
     */
    private function analyzeCsi() {
        if($templateWrapper = TemplateFactory::create($this->file)) {
            $templateWrapper->initialize();
            $rf = $templateWrapper->render($this->file, $this->csi->params->toArray());
        } else {
            $rf = get_include_contents($this->file, $this->csi->params->toArray());
        }
        $elements = JSON::decode(HTML::getElements($rf));
        $groups = HTML::getGroups($rf);
        $bindings = HTML::getBindings($rf);
        $this->processBindings($bindings, $elements);
        $requires="<?php\n";
        $gencsi="\nclass " . $this->eossClassName . "GenCSI extends \\EOSS\\CSI {\n\n";
        $gencsi.="\n\n";
        $csivi="";
        $csic = "\tpublic function __construct($"."eoss) {\n";
        $csic .= "\n\tparent::__construct($"."eoss);\n";
        $csic .= "\t\t$"."this->eoss="."$"."eoss;\n";
        $csic .= "\t\t$"."this->file='".$this->file."';\n";
        foreach($groups as $group) {
            $requires .= "require_once __DIR__ . '/genElements/" . $group . ".php';\n";
            $csivi .= "\t/**\n\t * @var " . $group . "\n\t */\n";
            $csivi .= "\tpublic $".$group.";\n";
            $csic .= "\t\t$"."this->".$group."=new ".$group.";\n";
        }
        foreach ($elements as $element) {
            if(key_exists('data_ignore', $element) && $element['data_ignore'] == 'true') {
                continue;
            }

            $file = "<?php\nclass {$element["id"]} { \n\n";
            $csivi .= "\t/**\n\t * @var {$element["id"]}\n\t */\n";
            $csivi .= "\tpublic $".$element["id"].";\n";
            $requires .= "require_once __DIR__ . '/genElements/".$element["id"].".php';\n";
            $csic .= "\t\t$"."this->".$element["id"]."=new ".$element["id"].";\n";
            foreach ($element as $key => $attribute) {
                if($this->isBounded($element["id"], $key)) {
                    $file .= "\t/**\n\t * @var \\Binding\\IBindedAttribute\n\t */\n";
                } else {
                    $file .= "\t/**\n\t * @var string\n\t */\n";
                }
                $file .= "\tpublic $" . $key. ";\n\n";
            }
            $listOfEvents=json_decode(file_get_contents(DIR_LIBS."EOSS/eventList.json"));
            foreach ($listOfEvents as $key => $value) {
                $file .= "\t/**\n\t * @var array\n\t */\n";
                $file .= "\tpublic $" . $key . " = array();\n\n";
            }
            $file .= "\n\tpublic function __construct() { \n";
            foreach ($element as $key => $attribute) {
                $attribute=str_replace('"', '\"', $attribute);
                $file .= "\t\t$"."this->" . $key . '="'.$attribute.'"'.";\n";
            }
            $file .= "\t}\n\n";
            $file .= "}\n";
            CSIHelper::genElement($element["id"], $file);
        }
        $gencsi = $requires.$gencsi;
        $gencsi .= $csivi."\n";
        $csic .= "\t}\n";
        $gencsi .= $csic;
        $gencsi .= "\tpublic function setFile($"."dir) {\n";
        $gencsi .= "\t\t$"."this->file="."$"."dir;\n";
        $gencsi .= "\t\t$"."this->csiAnalyze=new \\EOSS\\CSIAnalyze($"."dir, $"."this->eoss, $"."this);\n";
        $gencsi .= "\t\t$"."this->eoss->loadGeneratedCSI();\n";
        $gencsi .= "\t}\n";
        $gencsi .= "}\n";

        foreach($groups as $groupName) {
            $this->generateGroup($groupName);
        }

        CSIHelper::genCSI($gencsi, $this->eossClassName);
    }

    /**
     * Generates the group inside groupName.php
     * @param string $groupName
     */
    private function generateGroup($groupName) {
        $file = "<?php\n\n";
        $file .= "class " . $groupName . " {\n\n";

        $file .= "\t/**\n\t * @var string\n\t */\n";
        $file .= "\tpublic $"."type = \"group\";\n";
        $file .= "\t/**\n\t * @var string\n\t */\n";
        $file .= "\tpublic $"."id = \"" . $groupName . "\";\n";


        $listOfEvents=json_decode(file_get_contents(DIR_LIBS."EOSS/eventList.json"));
        foreach ($listOfEvents as $key => $value) {
            $file .= "\t/**\n\t * @var array\n\t */\n";
            $file .= "\tpublic $" . $key . " = array();\n\n";
        }
        $file .= "\n}";

        CSIHelper::genElement($groupName, $file);
    }

    private function processBindings($bindings, $elements) {

        foreach($bindings as $binding) {
            $json = JSON::decode($binding);

            $bindedElement = NULL;
            foreach($elements as $element) {
                if(key_exists('data_binding', $element) && $element['data_binding'] == $binding) {
                    $bindedElement = $element;
                }
            }

            if(!isset($json["Mode"])) {
                $json["Mode"] = "two-way";
            }

            if(isset($json["SourceElement"]) && isset($json["SourceAttribute"]) && isset($json["TargetAttribute"])) {
                $this->csi->bindings[] = new ElementBinding($json["SourceElement"], $json["SourceAttribute"], $json["TargetAttribute"], $json["Mode"], $binding);
            } else if(isset($json["SourcePath"]) && isset($json["TargetAttribute"])) {
                $this->csi->bindings[] = new PropertyBinding($json["SourcePath"], $json["TargetAttribute"], $json["Mode"], $binding, $bindedElement);
            }
        }

    }

    /**
     * @param string $elementID
     * @param string $attribute
     * @return bool
     */
    private function isBounded($elementID, $attribute) {
        foreach($this->csi->bindings as $binding) {
            if($binding instanceof PropertyBinding) {
                if($binding->getMode() == "two-way" && $binding->getTargetAttribute() == $attribute && $binding->getElement() == $elementID) {
                    return TRUE;
                }
            }
        }
        return FALSE;
    }


}
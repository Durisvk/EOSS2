<?php

namespace EOSS;


use Utils\CSIHelper;
use Utils\HTML;

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
        $rf = get_include_contents($this->file, $this->csi->params->toArray());
        $elements = HTML::getElements($rf);
        $requires="<?php\n";
        $gencsi="\nclass " . $this->eossClassName . "GenCSI extends \\EOSS\\CSI {\n\n";
        $gencsi.="\n\n";
        $csivi="";
        $csic = "\tpublic function __construct($"."eoss) {\n";
        $csic .= "\n\tparent::__construct($"."eoss);\n";
        $csic .= "\t\t$"."this->eoss="."$"."eoss;\n";
        $csic .= "\t\t$"."this->file='".$this->file."';\n";
        foreach (json_decode($elements) as $element) {
            $file = "<?php\nclass ".$element->id." { \n\n";
            $csivi .= "\t/**\n\t * @var " . $element->id . "\n\t */\n";
            $csivi .= "\tpublic $".$element->id.";\n";
            $requires .= "require_once __DIR__ . '/genElements/".$element->id.".php';\n";
            $csic .= "\t\t$"."this->".$element->id."=new ".$element->id.";\n";
            foreach ($element as $key => $attribute) {
                $file .= "\t/**\n\t * @var string\n\t */\n";
                $file .= "\tpublic $" . str_replace("-", "_", $key). ";\n";
            }
            $file .= "\n\tpublic function __construct() { \n";
            foreach ($element as $key => $attribute) {
                $attribute=str_replace('"', '\"', $attribute);
                $file .= "\t\t$"."this->" . str_replace("-", "_", $key) . '="'.$attribute.'"'.";\n";
            }
            $file .= "\t}\n\n";
            $file .= "}\n";
            CSIHelper::genElement($element->id, $file);
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
        CSIHelper::genCSI($gencsi, $this->eossClassName);
    }

}
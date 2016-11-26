<?php

namespace EOSS;


use Debug\Linda;
use Utils\JavascriptGenerator;
use Utils\RequireHelper;
use Utils\Session;

/**
 * Base class for controllers.
 * Class EOSS
 * @package EOSS
 */
abstract class EOSS
{

    /**
     * Client side interface
     * @var CSI
     */
    public $csi;

    /**
     * @var null|string
     */
    public $redirect = NULL;

    /**
     * EOSS constructor.
     */
    public function __construct()
    {
        $this->csi = new CSI($this);
        $this->load();
    }

    /**
     * Loads the generated CSI from genCSI.php file/
     */
    public function loadGeneratedCSI() {
        /** @var Parameters $params */
        $params = $this->csi->params;
        RequireHelper::requireFilesInDirectory(DIR_TEMP);
        $r = new \ReflectionClass("\\" . get_class($this) . "GenCSI");
        $this->csi = $r->newInstanceArgs([$this]);
        $this->csi->params = $params;
        $this->bind();
        JavascriptGenerator::generateJavascript($this);
    }

    /**
     * Should contain all of the initial loading logic (setFile, ...)
     * CSI is not generated at this time.
     */
    public abstract function load();

    /**
     * Should contain all of the binding logic
     * and all the logic with CSI because it's generated
     * at this time.
     */
    public abstract function bind();


    public function redirect($eoss = NULL) {
        $this->redirect = isset($eoss) ? $eoss : get_class($this);
        Session::getInstance()->set("currentEOSS", $this->redirect);
        if(!headers_sent()) {
            header("Refresh:0");
        }
    }
}
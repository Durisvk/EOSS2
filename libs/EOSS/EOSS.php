<?php
namespace EOSS;
use Debug\Linda;
use Forms\Form;
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
     * Variable CSI - Client side interface
     * @var CSI|\indexEOSSGenCSI
     */
    public $csi;

    /**
     * @var null|string
     */
    public $redirect = NULL;

    /**
     * @var Form[]
     */
    private $forms = [];

    /**
     * @var array
     */
    private $flashes = [];

    /**
     * EOSS constructor.
     */
    public function __construct()
    {
        $this->flashes = Session::getInstance()->get("flashes") ?: [];
    }

    /**
     * Called after the dependencies are injected.
     */
    public function init() {
        $this->csi = new CSI($this);
        $this->load();
    }

    /**
     * Loads the generated CSI from genCSI.php file/
     */
    public function loadGeneratedCSI() {
        /** @var Parameters $params */
        $params = $this->csi->params;
        $bindings = $this->csi->bindings;
        RequireHelper::requireFilesInDirectory(DIR_TEMP . "data/");
        $r = new \ReflectionClass("\\" . get_class($this) . "GenCSI");
        $this->csi = $r->newInstanceArgs([$this]);
        $this->csi->params = $params;
        $this->csi->bindings = $bindings;
        $this->csi->processBindings();
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

    /**
     * Redirects the page to EOSS passed as argument
     * If no argument's passed, the page is refreshed.
     * @param null|EOSS $eoss
     */
    public function redirect($eoss = NULL) {
        $this->redirect = isset($eoss) ? $eoss : get_class($this);
        Session::getInstance()->set("currentEOSS", $this->redirect);
        if(!headers_sent()) {
            header("Refresh:0");
        }
    }

    /**
     * Registers the form. Need to be called if onsubmit should work.
     * @param Form $form
     */
    public function registerForm(Form $form) {
        $this->forms[] = $form;
    }

    /**
     * @return Form[]
     */
    public function getForms() {
        return $this->forms;
    }

    /**
     * Finds the form by name.
     * @param string $name
     * @param bool $need
     * @return Form|null
     * @throws \Exception
     */
    public function getForm($name, $need = FALSE) {
        /** @var Form $form */
        foreach($this->forms as $form) {
            if($form->getName() == $name) {
                return $form;
            }
        }
        if($need) {
            throw new \Exception("Form with name \"{$name}\" not found.");
        } else {
            return NULL;
        }
    }

    /**
     * Pushes the flash message.
     * @param string $message
     * @param string $class
     */
    public function flashMessage($message, $class) {
        $this->flashes[$class] = $message;
    }


    /**
     * Pops the first flash from the flashes if it does exist
     * else returns null.
     * @return array|null
     */
    public function popFlashMessage() {
        if(count($this->flashes) != 0) {
            $flash = ["class" => array_keys($this->flashes)[0],
                        "message" => $this->flashes[array_keys($this->flashes)[0]]];
            unset($this->flashes[$flash["class"]]);

            return $flash;
        }
        return NULL;
    }

    /**
     * Gets the count of flash messages.
     * @return int
     */
    public function getCountOfFlashMessages() {
        return count($this->flashes);
    }

    public function __destruct() {
        Session::getInstance()->set("flashes", $this->flashes);
    }
}
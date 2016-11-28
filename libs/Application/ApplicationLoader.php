<?php

namespace Application\ApplicationLoader;
use Application\Config;
use Debug\Linda;
use EOSS\EOSS;
use Http\Request;
use Utils\RequireHelper;
use Utils\Session;
use Utils\Strings;

/**
 * Loads the application
 * Class ApplicationLoader
 * @package Application\ApplicationLoader
 */
class ApplicationLoader {

    /**
     * Files in app directory.
     * @var array
     */
    public $app=array();

    /**
     * ApplicationLoader constructor.
     */
    public function __construct() {
        $this->goThroughAppFiles(DIR_APP);
    }

    /**
     * Initializes the selected EOSS class.
     * @param null $eossreq
     * @return EOSS
     * @throws \Exception
     */
    public function eossInit($eossreq=null) {

        if(Config::getParam("refresh") && !Request::getInstance()->isAjax()) {

            Session::getInstance()->clearEOSSData();
        }

        $eoss = NULL;
        $matches=preg_grep("/([a-zA-Z])+EOSS\.php/",$this->app);
        foreach($matches as $match) {
            $cls=explode('/',$match);
            $cls=$cls[count($cls)-1];
            $cls=explode('.',$cls);
            $cls=$cls[0];
            if(isset($eossreq) && $eossreq==$cls) {
                require_once $match;
                /** @var EOSS $eoss */
                $eoss=new $cls;
                if(!Request::getInstance()->isAjax()) {
                    $this->loadView($eoss->csi->getFile(), $eoss);
                }
                return $eoss;
            } else {
                if(Session::getInstance()->get('currentEOSS')) {
                    if($cls==Session::getInstance()->get('currentEOSS') || Strings::startsWith($cls, Session::getInstance()->get('currentEOSS'))) {
                        require_once $match;
                        /** @var EOSS $eoss */
                        $eoss=new $cls;
                        if(!Request::getInstance()->isAjax()) {
                            $this->loadView($eoss->csi->getFile(), $eoss);
                        }
                    }
                } else if(Config::getParam("home_eoss")==$cls) {
                    Session::getInstance()->set("currentEOSS",Config::getParam("home_eoss"));
                    require_once $match;
                    /** @var EOSS $eoss */
                    $eoss=new $cls;
                    if(!Request::getInstance()->isAjax()) {
                        $this->loadView($eoss->csi->getFile(), $eoss);
                    }
                }
            }
        }
        if(!$eoss) {
            throw new \Exception("No EOSS class was found. Make sure you've created xyzEOSS.php with the appropriate class within it.");
        }
    }

    /**
     * Goes through the files in app directory
     * @param string $dir
     */
    private function goThroughAppFiles($dir) {
        $dirHandle=opendir($dir);
        while($file = readdir($dirHandle)){
            if(is_dir(DIR_APP . $file) && $file != '.' && $file != '..'){
                $this->goThroughAppFiles($dir.$file."/");
            }
            else if($file!='.' && $file!='..') {
                array_push($this->app,$dir.$file);
            }
        }
    }

    /**
     * Loads the view.
     * @param string $filename
     * @param EOSS $eoss
     */
    public function loadView($filename, EOSS $eoss) {
        extract($eoss->csi->params->toArray());
        include $filename;
    }

    /**
     * Includes all of the models.
     */
    public function includeModels() {
        $dir = DIR_APP . \Application\Config::getParam("models");
        if(file_exists($dir)) {
            RequireHelper::requireFilesInDirectory($dir);
        }
    }

}

?>

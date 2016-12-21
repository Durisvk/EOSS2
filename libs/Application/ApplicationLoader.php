<?php

namespace Application;
use Application\Config;
use Debug\Linda;
use EOSS\EOSS;
use Http\Request;
use Pimple\Container;
use Templating\TemplateFactory;
use Utils\RequireHelper;
use Utils\Session;
use Utils\Strings;

/**
 * Loads the application
 *
 * @author Juraj Čarnogurský
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
     * @var Container
     */
    private $container;

    /**
     * ApplicationLoader constructor.
     */
    public function __construct() {
        $this->container = new Container();
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

        $this->loadServices();

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
                $eoss=$this->createEOSSInstance($cls);
                $this->injectDependencies($eoss);
                $eoss->init();
                if(!Request::getInstance()->isAjax()) {
                    $this->loadView($eoss->csi->getFile(), $eoss);
                }
                return $eoss;
            } else {
                if(Session::getInstance()->get('currentEOSS')) {
                    if($cls==Session::getInstance()->get('currentEOSS') || Strings::startsWith($cls, Session::getInstance()->get('currentEOSS'))) {
                        require_once $match;
                        /** @var EOSS $eoss */
                        $eoss=$this->createEOSSInstance($cls);
                        $this->injectDependencies($eoss);
                        $eoss->init();
                        if(!Request::getInstance()->isAjax()) {
                            $this->loadView($eoss->csi->getFile(), $eoss);
                        }
                    }
                } else if(Config::getParam("home_eoss")==$cls) {
                    Session::getInstance()->set("currentEOSS",Config::getParam("home_eoss"));
                    require_once $match;
                    /** @var EOSS $eoss */
                    $eoss=$this->createEOSSInstance($cls);
                    $this->injectDependencies($eoss);
                    $eoss->init();
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
        if($templateWrapper = TemplateFactory::create($filename)) {
            $templateWrapper->initialize();
            echo $templateWrapper->render($filename, $eoss->csi->params->toArray());
        } else {
            extract($eoss->csi->params->toArray());
            include $filename;
        }
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

    /**
     * Injects all of the dependencies to the EOSS.
     * @param EOSS $eoss
     * @throws \Exception
     */
    public function injectDependencies(EOSS $eoss) {
        $reflection = new \ReflectionClass(get_class($eoss));

        /** @var \ReflectionMethod $method */
        foreach($reflection->getMethods() as $method) {
            if(Strings::startsWith($method->getName(), "inject") && count($method->getParameters()) == 1 && $method->isPublic()) {
                $param = $method->getParameters()[0];
                $param->getClass()->getName();
                if(isset($this->container[$param->getClass()->getName()])) {
                    call_user_func_array(array($eoss, $method->getName()), array($this->container[$param->getClass()->getName()]));
                } else {
                    throw new \Exception(sprintf("You forgot to register the service \"%s\". Go to services.eoss and register it.", $param->getClass()->getName()));
                }
            }
        }

        /** @var \ReflectionProperty $property */
        foreach($reflection->getProperties() as $property) {
            $doc = $property->getDocComment();
            if (strpos($doc, "@inject") && $property->isPublic()) {
                $matches = [];
                preg_match("/[\/\*\n ]+@var ([A-Za-z]{1}[A-Za-z0-9]+) @inject[\*\n \/]+/", $doc, $matches);
                if(count($matches) >= 2) {
                    if (isset($this->container[$matches[1]])) {
                        $eoss->{$property->getName()} = $this->container[$matches[1]];
                    } else {
                        throw new \Exception(sprintf("You forgot to register the service \"%s\". Go to services.eoss and register it.", $matches[1]));
                    }
                }
            }
        }
    }

    /**
     * Creates an EOSS instance with injected dependencies through constructor.
     * @param string $cls
     * @return object
     * @throws \Exception
     */
    public function createEOSSInstance($cls) {
        $reflection = new \ReflectionClass($cls);
        $args = [];
        /** @var \ReflectionParameter $param */
        foreach($reflection->getConstructor()->getParameters() as $param) {
            if(isset($this->container[$param->getClass()->getName()])) {
                $args[] = $this->container[$param->getClass()->getName()];
            } else {
                throw new \Exception(sprintf("You forgot to register the service \"%s\". Go to services.eoss and register it.", $param->getClass()->getName()));
            }
        }
        return $reflection->newInstanceArgs($args);
    }

    /**
     * Loads the all services specified inside services.eoss.
     */
    public function loadServices() {
        $services = Config::getParam("services");

        foreach($services as $service) {

            $this->container[$service] = function($c) use($service) {
                $reflection = new \ReflectionClass($service);
                $args = [];
                if($reflection->getConstructor()) {
                    /** @var \ReflectionParameter $param */
                    foreach ($reflection->getConstructor()->getParameters() as $param) {
                        if(isset($c[$param->getClass()->getName()])) {
                            $args[] = $c[$param->getClass()->getName()];
                        } else {
                            throw new \Exception(sprintf("You forgot to register the service \"%s\". Go to services.eoss and register it.", $param->getClass()->getName()));
                        }
                    }
                }
                return $reflection->newInstanceArgs($args);
            };

        }
    }

}

?>

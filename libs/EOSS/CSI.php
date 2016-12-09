<?php

namespace EOSS;
use Binding\BindableProperty;
use Binding\BindedAttribute;
use Binding\PropertyBinding;
use Debug\Linda;


/**
 * CSI - stands for Client Side Interface
 * It's a class that contains all of the information
 * about the DOM structure of view.
 * Class CSI
 * @package EOSS
 */
class CSI
{
    /**
     * @var CSIAnalyze
     */
    protected $csiAnalyze;

    /**
     * @var EOSS
     */
    public $eoss;

    /**
     * @var string
     */
    protected $file;

    /**
     * Params that are sent to view.
     * @var null|Parameters
     */
    public $params = NULL;

    /**
     * @var array
     */
    public $bindings = [];

    /**
     * @var array
     */
    public $intervals = [];

    /**
     * CSI constructor.
     * @param EOSS $eoss
     */
    public function __construct(EOSS $eoss)
    {
        $this->params = new Parameters();
        $this->eoss = $eoss;
    }

    /**
     * Sets the view file and generates the backend for it.
     * @param string $dir
     */
    public function setFile($dir)
    {
        $this->file = $dir;
        //$obj = new \ReflectionClass($this->eoss);
        //$eossFile = $obj->getFileName();
        $this->csiAnalyze = new CSIAnalyze($this->file, get_class($this->eoss), $this);
        $this->eoss->loadGeneratedCSI();
    }

    /**
     * Returns the view file path.
     * @return string
     */
    public function getFile() {
        return $this->file;
    }

    /**
     * Processes the bindings. Shouldn't be called by the user.
     */
    public function processBindings() {

        foreach($this->bindings as $binding) {
            if($binding instanceof PropertyBinding) {
                $element = $this->{$binding->getElement()} ?: NULL;

                $array = PropertyBinding::getObjectByPath($this->eoss, $binding->getSourcePath());
                $obj = $array["object"];
                $key = $array["key"];
                if(property_exists($obj, $key)) {
                    $reflector = new \ReflectionClass(get_class($obj));

                    $prop = $reflector->getProperty($key);

                    if ($prop->isPrivate() || $prop->isProtected()) {
                        // Hack:
                        $prop->setAccessible(TRUE);
                        $value = $prop->getValue($obj);
                        $prop->setValue($obj, new BindableProperty($value, $element, $binding->getTargetAttribute()));
                    } else {
                        $obj->{$key} = new BindableProperty($obj->{$key}, $element, $binding->getTargetAttribute());
                    }
                } else {
                    throw new \Exception("Property cannot be binded, \"{$key}\" was not found.");
                }
                if($element && $binding->getMode() == "two-way") {
                    $val = $element->{$binding->getTargetAttribute()};
                    $element->{$binding->getTargetAttribute()} = new BindedAttribute($val, $obj, $key);
                }
            }
        }

    }

}
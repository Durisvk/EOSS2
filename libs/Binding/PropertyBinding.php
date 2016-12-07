<?php

namespace Binding;


use Debug\Linda;
use EOSS\EOSS;

/**
 * Class PropertyBinding
 * @package Binding
 */
class PropertyBinding
{

    /**
     * @var string
     */
    private $sourcePath;

    /**
     * @var string
     */
    private $targetAttribute;

    /**
     * @var string
     */
    private $mode;

    /**
     * @var string
     */
    private $string;


    /**
     * Sets the property value.
     * @param EOSS $eoss
     * @param string $sourcePath
     * @param mixed $value
     * @throws \Exception
     */
    public static function setValue(EOSS $eoss, $sourcePath, $value) {
        $path = explode(".", $sourcePath);
        $key = array_pop($path);

        if(count($path) > 0) {
            if(property_exists($eoss, $path[0])) {
                $obj = NULL;
                $refl = new \ReflectionClass(get_class($eoss));
                if ($refl->getProperty($path[0])->isPublic()) {
                    $obj = $eoss->{$path[0]};
                } else if(method_exists($eoss, "get".ucfirst($path[0]))) {
                    $method = "get".ucfirst($path[0]);
                    $obj = $eoss->$method();
                } else {
                    throw new \Exception("Property \"{$path[0]}\" is inaccessible inside \"" . get_class($eoss) . "\"");
                }
                array_shift($path);
                foreach ($path as $p) {
                    if($obj) {
                        if(property_exists($obj, $p)) {
                            $refl = new \ReflectionClass($obj);
                            if($refl->getProperty($p)->isPublic()) {
                                $obj = $obj->{$p};
                            } else if(method_exists($obj, "get".ucfirst($p))) {
                                $method = "get".ucfirst($p);
                                $obj = $obj->$method();
                            } else {
                                throw new \Exception("Property \"{$p}\" is inaccessible inside \"" . get_class($obj) . "\"");
                            }
                        } else {
                            throw new \Exception("Invalid Binding SourcePath: \"{$sourcePath}\". Property \"{$p}\" doesn't exist inside \"" . get_class($obj) . "\".");
                        }
                    }
                }
            } else {
                throw new \Exception("Invalid Binding SourcePath: \"{$sourcePath}\". Property \"{$path[0]}\" doesn't exist inside \"" . get_class($eoss) . "\".");
            }
        } else {
            $obj = $eoss;
        }

        if(property_exists($obj, $key)) {
            $reflector = new \ReflectionClass(get_class($obj));

            $prop = $reflector->getProperty($key);

            if ($prop->isPrivate() || $prop->isProtected()) {
                if(method_exists($obj, "set".ucfirst($key))) {
                    $method = "set" . ucfirst($key);
                    $val = $obj->$method($value);
                } else {
                    throw new \Exception("Property \"{$key}\" is inaccessible.");
                }
            } else {
                $obj->{$key} = $value;
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
        $path = explode(".", $sourcePath);
        $key = array_pop($path);

        if(count($path) > 0) {
            if(property_exists($eoss, $path[0])) {
                $obj = NULL;
                $refl = new \ReflectionClass(get_class($eoss));
                if ($refl->getProperty($path[0])->isPublic()) {
                    $obj = $eoss->{$path[0]};
                } else if(method_exists($eoss, "get".ucfirst($path[0]))) {
                    $method = "get".ucfirst($path[0]);
                    $obj = $eoss->$method();
                } else {
                    throw new \Exception("Property \"{$path[0]}\" is inaccessible inside \"" . get_class($eoss) . "\"");
                }
                array_shift($path);
                foreach ($path as $p) {
                    if($obj) {
                        if(property_exists($obj, $p)) {
                            $refl = new \ReflectionClass($obj);
                            if($refl->getProperty($p)->isPublic()) {
                                $obj = $obj->{$p};
                            } else if(method_exists($obj, "get".ucfirst($p))) {
                                $method = "get".ucfirst($p);
                                $obj = $obj->$method();
                            } else {
                                throw new \Exception("Property \"{$p}\" is inaccessible inside \"" . get_class($obj) . "\"");
                            }
                        } else {
                            throw new \Exception("Invalid Binding SourcePath: \"{$sourcePath}\". Property \"{$p}\" doesn't exist inside \"" . get_class($obj) . "\".");
                        }
                    }
                }
            } else {
                throw new \Exception("Invalid Binding SourcePath: \"{$sourcePath}\". Property \"{$path[0]}\" doesn't exist inside \"" . get_class($eoss) . "\".");
            }
        } else {
            $obj = $eoss;
        }

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
     * PropertyBinding constructor.
     * @param string $sourcePath
     * @param string $targetAttribute
     * @param string $mode
     * @param string $string
     */
    public function __construct($sourcePath, $targetAttribute, $mode, $string) {
        $this->sourcePath = $sourcePath;
        $this->targetAttribute = $targetAttribute;
        $this->mode = $mode;
        $this->string = $string;
    }

    /**
     * @return string
     */
    public function getSourcePath()
    {
        return $this->sourcePath;
    }

    /**
     * @return string
     */
    public function getTargetAttribute()
    {
        return $this->targetAttribute;
    }

    /**
     * @return string
     */
    public function getMode()
    {
        return $this->mode;
    }

    /**
     * @return string
     */
    public function getString()
    {
        return $this->string;
    }


    /**
     * @param EOSS $eoss
     * @return string
     * @throws \Exception
     */
    public function initialJavascript(EOSS $eoss) {

        if($val = self::getValue($eoss, $this->getSourcePath())) {
            $js = "$( \"[data-binding=\\\"{$this->getString()}\\\"]\" ).";

            if($this->getTargetAttribute() == "html") {
                $js .= "html(";
            } else if($this->getTargetAttribute() == "value") {
                $js .= "val(";
            } else {
                $js .= "attr(\"{$this->getTargetAttribute()}\", ";
            }

            $js .= is_string($val) ? "\"{$val}\"" : $val;
            $js .= ");";
            $js = "$( \"[data-binding=\\\"{$this->getString()}\\\"]\" ).change();";
        } else {
            $js = "";
        }


        return $js;

    }

    public function getResponseJavascript(EOSS $eoss) {
        if($val = self::getValue($eoss, $this->getSourcePath())) {
            $js = "$( \"[data-binding=\\\"{$this->getString()}\\\"]\" ).";

            if($this->getTargetAttribute() == "html") {
                $js .= "html(";
            } else if($this->getTargetAttribute() == "value") {
                $js .= "val(";
            } else {
                $js .= "attr(\"{$this->getTargetAttribute()}\", ";
            }

            $js .= is_string($val) ? "\"{$val}\"" : $val;
            $js .= ");\n";
            $js .= "$( \"[data-binding=\\\"{$this->getString()}\\\"]\" ).change();";
        } else {
            $js = "";
        }


        return $js;
    }

}
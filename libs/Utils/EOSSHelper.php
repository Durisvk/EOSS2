<?php


namespace Utils;


use EOSS\EOSS;

class EOSSHelper
{

    public static function storeClassVariables($eoss,$name) {
        Session::getInstance()->set($name, "");
        unset($eoss->csi->eoss);
        foreach($eoss as $key => $value) {
            if($value instanceof \Binding\IBindableProperty) {
                $eoss->$key = $value->get();
            }
        }
        $vars = get_object_vars($eoss);
        foreach($vars as $key => $value) {
            if(!is_scalar($value) && $key != 'csi') {
                $vars[$key] = 'model';
            }
        }
        Session::getInstance()->set($name,json_encode());

    }
    public static function restoreClassVariables(&$eoss,$name) {
        $json=Session::getInstance()->get($name);
        $eoss=self::jsonToEoss($eoss,JSON::decode($json));
    }

    /**
     * Loads the EOSS from JSON format
     * @param EOSS $eoss
     * @param array $json
     * @return mixed
     */
    public static function jsonToEoss ($eoss,$json) {
        foreach ($json as $key=>$val) {
            if($key == "csi") {
                foreach ($val as $elkey=>$elval) {
                    foreach($elval as $attkey=>$attval) {
                        if(isset($eoss->$key->$elkey->$attkey) && !Strings::startsWith($attkey, 'on')) {
                            $eoss->$key->$elkey->$attkey = $attval;
                        }
                    }
                }
            } else {
                if($key != "redirect") {
                    if($eoss->$key instanceof \Binding\IBindableProperty) {
                        $eoss->$key->set($val);
                    } else if($eoss->$key instanceof \Binding\BindableCollection) {
                        $eoss->$key->setValue($val);
                    }else {
                        if($val != "model") {
                            continue;
                        }
                        $eoss->$key = $val;
                    }
                }
            }
        }
        return $eoss;
    }

}
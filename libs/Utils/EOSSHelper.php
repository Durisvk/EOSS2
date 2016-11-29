<?php


namespace Utils;


use Debug\Linda;

class EOSSHelper
{

    public static function storeClassVariables($eoss,$name) {
        Session::getInstance()->set($name, "");
        unset($eoss->csi->eoss);
        Session::getInstance()->set($name,json_encode(get_object_vars($eoss)));

    }
    public static function restoreClassVariables(&$eoss,$name) {
        $json=Session::getInstance()->get($name);
        $eoss=self::jsonToEoss($eoss,json_decode($json));
    }

    static function jsonToEoss ($eoss,$json) {
        foreach ($json as $key=>$val) {
            if(is_object($val)) {
                foreach ($val as $elkey=>$elval) {
                    foreach($elval as $attkey=>$attval) {
                        if(isset($eoss->$key->$elkey->$attkey) && !Strings::startsWith($attkey, 'on')) {
                            $eoss->$key->$elkey->$attkey = $attval;
                        }
                    }
                }
            } else {
                if($key != "redirect") {
                    $eoss->$key = $val;
                }
            }
        }
        return $eoss;
    }

}
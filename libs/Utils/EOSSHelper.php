<?php


namespace Utils;


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
        Session::getInstance()->set($name,json_encode(get_object_vars($eoss)));

    }
    public static function restoreClassVariables(&$eoss,$name) {
        $json=Session::getInstance()->get($name);
        $eoss=self::jsonToEoss($eoss,JSON::decode($json));
    }

    static function jsonToEoss ($eoss,$json) {
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
                        $eoss->$key = $val;
                    }
                }
            }
        }
        return $eoss;
    }

}
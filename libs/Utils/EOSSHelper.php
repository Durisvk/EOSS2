<?php


namespace Utils;


use EOSS\EOSS;

class EOSSHelper
{

    public static function storeClassVariables($eoss,$name) {
        Session::getInstance()->set($name, "");
        Session::getInstance()->set($name,serialize($eoss));

    }
    public static function restoreClassVariables(&$eoss,$name) {
        $data=Session::getInstance()->get($name);
        $eoss = unserialize($data);
    }
}
<?php


namespace Utils;


use EOSS\EOSS;

/**
 * Simple EOSS state saving and restoring class.
 * Class EOSSHelper
 * @package Utils
 */
class EOSSHelper
{

    /**
     * Saves the EOSS state into sessions.
     * @param EOSS $eoss
     * @param string $name
     */
    public static function storeClassVariables(EOSS $eoss,$name) {
        Session::getInstance()->set($name, "");
        Session::getInstance()->set($name,serialize($eoss));
    }

    /**
     * Restores the EOSS state from the sessions.
     * @param EOSS $eoss
     * @param string $name
     */
    public static function restoreClassVariables(EOSS &$eoss,$name) {
        $data=Session::getInstance()->get($name);
        $eoss = unserialize($data);
    }
}
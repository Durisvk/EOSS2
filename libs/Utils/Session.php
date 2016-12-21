<?php

namespace Utils;
use Application\Config;


/**
 * Singleton class that serves as session wrapper.
 *
 * @author Juraj Čarnogurský
 * Class Session
 * @package Utils
 */
class Session
{

    /**
     * @var null|Session
     */
    private static $instance = NULL;

    /**
     * Session constructor.
     */
    private function __construct() {

        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

    }


    /**
     * Returns the session value at key $key if its $need-ed
     * @param string $key
     * @param bool $need
     * @return null|mixed
     * @throws \Exception
     */
    public function get($key, $need = FALSE) {
        if(is_string($key)) {
            if(key_exists($key, $_SESSION)) {
                return $_SESSION[$key];
            } else if($need) {
                throw new \Exception("The key \"" . $key . "\" was not found in sessions.");
            }
        }
        return NULL;
    }


    /**
     * Sets the session with $_SESSION[$key] = $value and returns boolean if it was successful.
     * @param string $key
     * @param mixed $value
     * @return bool
     */
    public function set($key, $value) {
        if(is_string($key)) {
            $_SESSION[$key] = $value;
            return TRUE;
        }
        return FALSE;
    }


    /**
     * Clears the current session.
     */
    public function clear() {
        session_unset();
    }

    /**
     * Clears all the application EOSS data.
     * Except if refresh is set to false the current EOSS
     * stays stored.
     */
    public function clearEOSSData() {
        foreach($_SESSION as $key => $value) {
            if($key == "currentEOSS" && Config::getParam("refresh")) {
                continue;
            }
            if($key == "registryEOSS") continue;
            if(Strings::endsWith($key, "EOSS")) {
                unset($_SESSION[$key]);
            }
        }

    }

    /**
     * Singleton pattern.
     * @return Session
     */
    public static function getInstance() {

        if( !self::$instance ) {
            self::$instance = new Session();
        }

        return self::$instance;

    }
}
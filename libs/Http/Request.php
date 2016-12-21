<?php

namespace Http;


/**
 * Simple request wrapper, use as follows: Request::getInstance()->whatever...
 *
 * @author Juraj Čarnogurský
 * Class Request
 * @package Http
 */
class Request
{

    /**
     * @var null|Request
     */
    private static $instance = NULL;

    /**
     * @var bool
     */
    private $isAjax = FALSE;

    /**
     * Request constructor.
     * @param bool $isAjax
     */
    private function __construct($isAjax = FALSE)
    {
        $this->isAjax = $isAjax;
    }


    /**
     * If request is ajax returns true.
     * @return bool
     */
    public function isAjax() {
        return $this->isAjax;
    }


    public function getParameter($key, $need = FALSE) {
        if(isset($_GET[$key])) {
            return $_GET[$key];
        } else if(isset($_POST[$key])) {
            return $_POST[$key];
        }
        if($need) {
            throw new \Exception("Request parameter \"{$key}\" was not found.");
        }
        return NULL;
    }

    /**
     * Singleton pattern.
     * @param bool $isAjax
     * @return Request|null
     */
    public static function getInstance($isAjax = FALSE) {

        if(!self::$instance) {
            self::$instance = new Request($isAjax);
        }

        return self::$instance;
    }
}
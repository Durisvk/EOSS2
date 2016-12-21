<?php

namespace Http;


/**
 * Simple response wrapper. Use as singleton: Response::getInstance()->whatever...
 *
 * @author Juraj Čarnogurský
 * Class Response
 * @package Http
 */
class Response
{

    /**
     * @var null|Response
     */
    private static $instance = NULL;


    /**
     * @var string
     */
    private $output = "";

    /**
     * Response constructor.
     */
    private function __construct() {}


    /**
     * Appends the content into output.
     * @param string $str
     * @param bool $serious
     * @return $this
     */
    public function append($str, $serious = TRUE) {
        if($serious && Request::getInstance()->isAjax()) {
            return $this;
        }
        $this->output .= $str;
        return $this;
    }

    /**
     * Flushes the output on the screen of client.
     * (Doesn't need to be called. It's called at the end of core files.)
     * @return string
     */
    public function flush() {
        $temp_output = $this->output;
        echo $this->output;
        $this->output = "";
        return $temp_output;
    }


    /**
     * Gets the response instance. Singleton pattern.
     * @return Response
     */
    public static function getInstance() {

        if(!self::$instance) {
            self::$instance = new Response();
        }

        return self::$instance;
    }
}
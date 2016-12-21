<?php

namespace Utils;
use Debug\Linda;

/**
 * Simple JSON operations
 *
 * @author Juraj Čarnogurský
 * Class JSON
 * @package Utils
 */
class JSON
{

    /**
     * @param string $s
     * @param bool $asArray
     * @return mixed
     */
    public static function decode($s, $asArray = TRUE) {
        if(json_decode($s, $asArray)) {
            return json_decode($s, $asArray);
        }
        $s = str_replace(
            array('"',  "'"),
            array('\"', '"'),
            $s
        );
        $s = str_replace("\\\"", "\"", $s);
        $s = preg_replace('/(\w+):/i', '"\1":', $s);
        if(strpos($s, "{") === FALSE) {
            return json_decode(sprintf("{%s}", $s), $asArray);
        } else {
            return json_decode($s, $asArray);
        }
    }

}
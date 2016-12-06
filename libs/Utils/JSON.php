<?php

namespace Utils;
use Debug\Linda;

/**
 * Simple JSON operations
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
        $s = str_replace(
            array('"',  "'"),
            array('\"', '"'),
            $s
        );
        $s = preg_replace('/(\w+):/i', '"\1":', $s);
        if(!strpos($s, "{")) {
            return json_decode(sprintf("{%s}", $s), $asArray);
        } else {
            return json_decode($s, $asArray);
        }
    }

}
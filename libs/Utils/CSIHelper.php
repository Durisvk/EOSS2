<?php

namespace Utils;

/**
 * Helper class for CSI generating
 * Class CSIHelper
 * @package Utils
 */
class CSIHelper
{

    /**
     * Generates a xyzEOSSGenCSI.php file.
     * @param string $file
     * @param string $name
     */
    public static function genCSI($file, $name) {
        $genCSI=fopen(DIR_TEMP . "data/" . $name . "GenCSI.php", "w+") or die("Check out your permissions on file libs/data/!");
        fwrite($genCSI, $file);
        fclose($genCSI);
    }

    /**
     * Generates the file for DOM HTML element.
     * @param string $name
     * @param string $file
     */
    public static function genElement($name,$file) {
        $genel=fopen(DIR_TEMP . "data/genElements/".$name.".php", "w+") or die("Check out your permissions on file libs/data/!");
        fwrite($genel, $file);
        fclose($genel);
    }


}
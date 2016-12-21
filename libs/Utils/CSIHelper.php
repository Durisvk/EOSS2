<?php

namespace Utils;

/**
 * Helper class for CSI generating.
 *
 * @author Juraj Čarnogurský
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
        File::save(DIR_TEMP . "data/" . $name . "GenCSI.php", $file);
        $eossPath = DIR_LIBS . 'EOSS/EOSS.php';
        $eossFile = fopen($eossPath, 'rw');
        $data =fread($eossFile, filesize($eossPath));
        $lines = explode(PHP_EOL, $data);
        for($i = 0; $i < count($lines) - 1; $i++) {
            if(strpos($lines[$i], 'Variable CSI - Client side interface') !== FALSE && strpos($lines[$i + 1] , $name . "GenCSI") === FALSE) {
                $lines[$i + 1] .= '|\\' . $name . "GenCSI";
                file_put_contents($eossPath, implode(PHP_EOL, $lines));
                fclose($eossFile);
                return;
            }
        }
        fclose($eossFile);

    }

    /**
     * Generates the file for DOM HTML element.
     * @param string $name
     * @param string $file
     */
    public static function genElement($name,$file) {
        File::save(DIR_TEMP . "data/genElements/".$name.".php", $file);
    }


}
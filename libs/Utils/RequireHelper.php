<?php

namespace Utils;


/**
 * Class that requires all of the files inside directory
 *
 * @author Juraj Čarnogurský
 * Class RequireHelper
 * @package Utils
 */
class RequireHelper
{

    /**
     * Requires all of the files inside directory except specified in array as the second argument.
     * @param string $dir
     * @param array $except
     */
    public static function requireFilesInDirectory($dir, $except = array()) {
        $dirHandle=opendir($dir);
        while($file = readdir($dirHandle)){
            if(is_dir($dir.$file) && $file != '.' && $file != '..'){
                self::requireFilesInDirectory($dir.$file."/", $except);
            }
            else if($file!='.' && $file!='..') {
                if(pathinfo($dir.$file)['extension'] == 'php') {
                    if(!in_array($file, $except)) {
                        require_once $dir . $file;
                    }
                }
            }
        }
    }

}
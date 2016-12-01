<?php

namespace Utils;


/**
 * Class that requires all of the files inside directory
 * Class RequireHelper
 * @package Utils
 */
class RequireHelper
{

    /**
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
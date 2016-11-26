<?php

namespace Utils;


use Debug\Linda;

class RequireHelper
{

    public static function requireFilesInDirectory($dir) {
        $dirHandle=opendir($dir);
        while($file = readdir($dirHandle)){
            if(is_dir($dir.$file) && $file != '.' && $file != '..'){
                self::requireFilesInDirectory($dir.$file."/");
            }
            else if($file!='.' && $file!='..') {
                if(pathinfo($dir.$file)['extension'] == 'php') {
                    require_once $dir . $file;
                }
            }
        }
    }

}
<?php

/*function url_exists($url) {
    $handle   = curl_init($url);

    curl_setopt($handle, CURLOPT_HEADER, false);
    curl_setopt($handle, CURLOPT_FAILONERROR, true);
    curl_setopt($handle, CURLOPT_NOBODY, true);
    curl_setopt($handle, CURLOPT_RETURNTRANSFER, false);
    $connectable = curl_exec($handle);
    curl_close($handle);
    return $connectable;
}*/

function get_include_contents($filename) {
    if (is_file($filename)) {
        ob_start();
        include $filename;
        $contents = ob_get_contents();
        ob_end_clean();
        return $contents;
    }
    return false;
}



function createFolderIfDoesntExist($path) {
    if (!file_exists($path)) {
        mkdir($path, 0777, true);
    }
}

\EOSS\Registry::getInstance();

createFolderIfDoesntExist(DIR_TEMP.'data/genElements');
createFolderIfDoesntExist(DIR_TEMP.'data');
createFolderIfDoesntExist(DIR_TEMP.'data/genJs');


function __autoload($class_name) {
    if(class_exists($class_name)) return;
    $parts = explode('\\', $class_name);
    if(file_exists(end($parts).'.php')) {
        include end($parts).'.php';
    } else {
        $dirs = array_filter(glob(DIR_LIBS.'*'), 'is_dir');
        foreach ($dirs as $dir) {
            if(file_exists($dir . '/' . end($parts) . '.php')) {
                include $dir . '/' . end($parts) . '.php';
            }
        }
    }
}

// Setting debugger Linda:
set_error_handler ("showLinda");
register_shutdown_function('shutdown');
ini_set( "display_errors", "off" );
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
function showLinda ($errno,$errstr,$errfile,$errline){
    require_once DIR_LIBS."Debug/Linda.php";
    \Debug\Linda::outputLindaForPHPError($errstr,$errfile,$errline);
    exit();
}
function shutdown() {
    $error=error_get_last();
    require_once DIR_LIBS."Debug/Linda.php";
    \Debug\Linda::outputLindaForPHPError($error['message'],$error['file'],$error['line']);
    exit();
}




// Starting application:
$eossContainer=array();
$eossdir=array();
$apploader = new \Application\ApplicationLoader\ApplicationLoader();
$apploader->includeModels();
$apploader->eossInit();
include "requireJS.php";
?>
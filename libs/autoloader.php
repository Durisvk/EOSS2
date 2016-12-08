<?php
$start = microtime(TRUE);


require_once "vendor/autoload.php";

//require_once "Utils/RequireHelper.php";
//\Utils\RequireHelper::requireFilesInDirectory(DIR_LIBS, array("LindaLayout.php", "request.php", "autoloader.php", "requireJS.php"));

// autoload classes based on a 1:1 mapping from namespace to directory structure.
spl_autoload_register(function ($className) {

    # Usually I would just concatenate directly to $file variable below
    # this is just for easy viewing on Stack Overflow)
    $ds = DIRECTORY_SEPARATOR;
    $dir = __DIR__;

    // replace namespace separator with directory separator (prolly not required)
    $className = str_replace('\\', $ds, $className);

    // get full name of file containing the required class
    $file = "{$dir}{$ds}{$className}.php";

    // get file if it is readable
    if (is_readable($file)) require_once $file;
});

function get_include_contents($filename, $params = array()) {
    if (is_file($filename)) {
        ob_start();
        extract($params);
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
createFolderIfDoesntExist(DIR_TEMP);
createFolderIfDoesntExist(DIR_TEMP.'data/genElements');
createFolderIfDoesntExist(DIR_TEMP.'data');
createFolderIfDoesntExist(DIR_TEMP.'data/genJs');


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
$apploader = new \Application\ApplicationLoader();
$apploader->includeModels();
echo '<script   src="https://code.jquery.com/jquery-3.1.1.min.js"   integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="   crossorigin="anonymous"></script>';
$apploader->eossInit();
include "requireJS.php";
if(\Application\Config::getParam("enviroment") == "debug") {
    \Debug\Linda::showDebugBar($start);
}
?>
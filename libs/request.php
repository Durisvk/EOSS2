<?php

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


define('DIR_LIBS', getcwd().'/');
define('DIR_APP', getcwd().'/../app/');
define('DIR_TEMP', getcwd() . '/../temp/');
define('URL', "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
define('URL_LIBS', URL . 'libs/');
define('URL_TEMP', URL . 'temp/');
define('URL_APP', URL . 'app/');

\EOSS\Registry::getInstance();

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

$request = \Http\Request::getInstance(TRUE);


$app=new Application\ApplicationLoader\ApplicationLoader();
$app->includeModels();
$eoss=$app->eossInit($_GET['eoss']);
if(\Utils\Session::getInstance()->get($_GET['eoss'])) {\Utils\EOSSHelper::restoreClassVariables($eoss,get_class($eoss));}
foreach(json_decode($_GET['values']) as $value) {
    $id=$value->id;
    $eoss->csi->$id->value=$value->val;
}
if (isset($_GET['curValue']) && isset($_GET['id'])) {
    $eoss->csi->$_GET['id']->value=$_GET['curValue'];
}
$eoss->bind();
$bind_event = "";
//DO FUNCTION...
if(isset($_GET['id'])) {
    $bind_event = $eoss->csi->$_GET['id']->$_GET['event'];
} else {
    $bind_event = $_GET['event'];
}
//\Debug\Linda::dd(json_encode($eoss));

isset($_GET['param']) ? $eoss->$bind_event($_GET['param']) : $eoss->$bind_event();
if(isset($_GET['id'])) {
    \Utils\JavascriptGenerator::writeJsResponse($eoss, $_GET['id'] . $_GET['event']);
} else {
    \Utils\JavascriptGenerator::writeJsResponse($eoss, $_GET['event'] . 'Interval');
}
//...and then
\Utils\EOSSHelper::storeClassVariables($eoss,get_class($eoss));
\Http\Response::getInstance()->flush();
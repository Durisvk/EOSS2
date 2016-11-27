<?php

$start = microtime(TRUE);

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
$eoss=$app->eossInit($request->getParameter('eoss'));
if(\Utils\Session::getInstance()->get($request->getParameter('eoss'))) {\Utils\EOSSHelper::restoreClassVariables($eoss,get_class($eoss));}
foreach(json_decode($request->getParameter('values')) as $value) {
    $id=$value->id;
    $eoss->csi->$id->value=$value->val;
}
if ($request->getParameter('curValue') && $request->getParameter('id')) {
    $eoss->csi->{$request->getParameter('id')}->value=$request->getParameter('curValue');
}
$eoss->bind();
$bind_event = "";
//DO FUNCTION...
if($request->getParameter('id')) {
    $bind_event = $eoss->csi->{$request->getParameter('id')}->{$request->getParameter('event')};
} else {
    $bind_event = $request->getParameter('event');
}

$request->getParameter('param') ? $eoss->$bind_event($request->getParameter('param')) : $eoss->$bind_event();
if($request->getParameter('id')) {
    \Utils\JavascriptGenerator::writeJsResponse($eoss, $request->getParameter('id') . $request->getParameter('event'));
} else {
    \Utils\JavascriptGenerator::writeJsResponse($eoss, $request->getParameter('event') . 'Interval');
}
//...and then
\Utils\EOSSHelper::storeClassVariables($eoss,get_class($eoss));

\Debug\Linda::showDebugBar($start);

\Http\Response::getInstance()->flush();
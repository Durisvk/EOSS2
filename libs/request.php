<?php

$start = microtime(TRUE);

define('DIR', getcwd() . '/../');
define('DIR_LIBS', getcwd().'/');
define('DIR_APP', getcwd().'/../app/');
define('DIR_TEMP', getcwd() . '/../temp/');
define('URL', "http://$_SERVER[HTTP_HOST]".str_replace("libs/request.php", "", strtok($_SERVER['REQUEST_URI'], '?')));
define('URL_LIBS', URL . 'libs/');
define('URL_TEMP', URL . 'temp/');
define('URL_APP', URL . 'app/');

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


\EOSS\Registry::getInstance();

ini_set( "display_errors", "on" );
error_reporting(E_ERROR);

$request = \Http\Request::getInstance(TRUE);


$app=new Application\ApplicationLoader();
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


// store old values:
$oldValues = [];
foreach($eoss->csi as $key => $value) {
    if($key != "params" && $key != "eoss" && $key != "intervals") {
        $oldValues[$key] = clone $eoss->csi->$key;
    }
}

$bind_event = "";
//DO FUNCTION...
if($request->getParameter('id')) {
    $bind_event = $eoss->csi->{$request->getParameter('id')}->{$request->getParameter('event')};
} else if($request->getParameter("form")) {
    $bind_event = $eoss->getForm($request->getParameter("form"))->onsubmit;
} else {
    $bind_event = $request->getParameter('event');
}

$anonymousSender = NULL;;

$called = [];
if($request->getParameter('id')) {
    if($eoss->csi->{$request->getParameter('id')}->type == "group") {
        // If is group
        foreach($bind_event as $event) {
            if(!in_array($event, $called)) {

                $sender = NULL;
                if($attributes = $request->getParameter("anonymous")) {
                    $sender = new \EOSS\AnonymousSender();
                    foreach($attributes as $key => $value) {
                        $key = str_replace("-", "_", $key);
                        $sender->$key = $value;
                    }
                    $anonymousSender = $sender;
                } else {
                    $sender = $eoss->csi->{$request->getParameter('element_id')};
                }
                $request->getParameter('param') ? $eoss->$event($sender, $request->getParameter('param')) : $eoss->$event($sender);
                $called[] = $event;
            }
        }
    } else {
        // If is a single element
        foreach ($bind_event as $event) {
            if(!in_array($event, $called)) {
                $request->getParameter('param') ? $eoss->$event($eoss->csi->{$request->getParameter('id')}, $request->getParameter('param')) : $eoss->$event($eoss->csi->{$request->getParameter('id')});
                $called[] = $event;
            }
        }
    }
} else if($request->getParameter("form")) {
    // If it's form.

    $submittedForm = new \Forms\SubmittedForm();
    foreach($_POST as $key => $value) {
        if($key != "eoss" && $key != "form" && $key != "values") {
            $submittedForm->$key = $value;
        }
    }

    foreach($_FILES as $key => $value) {
        $submittedForm->$key = new \Http\FileUpload($value);
    }

    foreach($bind_event as $event) {
        $eoss->$event($submittedForm);
    }

} else {
    // If is interval...
    $request->getParameter('param') ? $eoss->$bind_event($request->getParameter('param')) : $eoss->$bind_event();
}

// get the changed values:
$changed = [];
foreach($oldValues as $key => $value) {
    foreach($eoss->csi->$key as $k => $v) {
        if(!is_string($v)) {
            if ($v != $value->$k) {
                $changed[$key] = $eoss->csi->$key;
            }
        } else {
            if (strcmp($value->$k, $v) != 0) {
                $changed[$key] = $eoss->csi->$key;
            }
        }
    }
}



if($request->getParameter('id')) {
    \Utils\JavascriptGenerator::writeJsResponse($eoss, $request->getParameter('id') . $request->getParameter('event'), $changed, $anonymousSender);
} else if($request->getParameter('form')) {
    \Utils\JavascriptGenerator::writeJsResponse($eoss, $request->getParameter('form') . 'Form', $changed);
} else {
    \Utils\JavascriptGenerator::writeJsResponse($eoss, $request->getParameter('event') . 'Interval', $changed);
}
//...and then
\Utils\EOSSHelper::storeClassVariables($eoss,get_class($eoss));

\Debug\Linda::showDebugBar($start);

\Http\Response::getInstance()->flush();
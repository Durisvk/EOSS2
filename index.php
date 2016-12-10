<?php
define('DIR', getcwd() . "/");
define('DIR_LIBS', getcwd().'/libs/');
define('DIR_APP', getcwd().'/app/');
define('DIR_TEMP', getcwd() . '/temp/');
define('URL', "http://$_SERVER[HTTP_HOST]".  str_replace("index.php", "", strtok($_SERVER['REQUEST_URI'], '?')));
define('URL_LIBS', URL . 'libs/');
define('URL_TEMP', URL . 'temp/');
define('URL_APP', URL . 'app/');

require 'libs/autoloader.php';

\Http\Response::getInstance()->flush();
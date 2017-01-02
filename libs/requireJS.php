<?php
$ex=false;

echo "\n<script src='" . URL_LIBS . "EOSS/functions.js'></script>";
foreach (new DirectoryIterator(DIR_TEMP."data/genJs/") as $file) {

    if(!$file->isDot()) {
        if($file->getFilename()!="genFunctions.js") {
            if(\Utils\Strings::startsWith($file->getFilename(), \Utils\Session::getInstance()->get("currentEOSS"))) {
                echo "\n<script src='" . URL_TEMP . "data/genJs/" . $file->getFilename() . "'></script>";
            }
        } else {
            $ex=true;
            echo "\n<div id='jsRefresh'><script src='" . URL_TEMP . "data/genJs/".$file->getFilename()."'></script></div>";
        }
    }
}
if($ex==false) echo "<div id='jsRefresh'></div>";

?>
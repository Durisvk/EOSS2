<?php
$ex=false;

echo '<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>';
foreach (new DirectoryIterator(DIR_TEMP."data/genJs/") as $file) {
    if(!$file->isDot()) {
        if($file->getFilename()!="genFunctions.js") {
            if(\Utils\Strings::startsWith($file->getFilename(), \Utils\Session::getInstance()->get("currentEOSS"))) {
                echo "<script src='" . URL_TEMP . "data/genJs/" . $file->getFilename() . "'></script>";
            }
        } else {
            $ex=true;
            echo "<div id='jsRefresh'><script src='" . URL_TEMP . "data/genJs/".$file->getFilename()."'></script></div>";
        }
    }
}
if($ex==false) echo "<div id='jsRefresh'></div>";
echo "<script src='" . URL_LIBS . "EOSS/functions.js'></script>";

?>
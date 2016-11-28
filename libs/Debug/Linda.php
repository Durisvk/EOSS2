<?php
namespace Debug;

use Http\Request;
use Http\Response;
use \Utils\File;
/**
 * Class Linda
 * @package Debug\Linda
 *
 * The class is created to display the debug information such as Errors, ...
 */
class Linda {
    /**
     * @var integer Starting time of execution.
     */
    public $timeStart;

    /**
     * @var integer Ending tme of execution.
     */
    public $timeEnd;

    /**
     * @var TODO: fill the documentation.
     */
    public $showLinda;

    /**
     * Shows the error
     * @param string $text
     * @param string $file
     * @param string $key
     */
    public static function showError($text,$file,$key) {
        self::outputLinda($text,$file,$key);
    }

    /**
     * Displays the error
     * @param string $text
     * @param string $errfile
     * @param string $key
     */
    private static function outputLinda($text,$errfile,$key) {
        $file=file_get_contents($errfile);
        $file=explode("\n",$file);
        $array=array ();
        $line=File::getLine($key,$file);
        for ($i=$line-3;$i<=$line+3;$i++) {
            if($i!=$line){
                array_push($array,"<span style='font-size: 10px;padding-right:10px'>".$i."</span>".$file[$i]);
            } else {
                array_push($array,"<span style='font-size: 10px;padding-right:10px'>".$i."</span><b style='color:red;'>".$file[$i]."</b>");
            }
        }
        include DIR_LIBS."Debug/LindaLayout.php";
    }

    /**
     * Displays the error other way.
     * @param string $errstr
     * @param string $errfile
     * @param integer $errline
     */
    public static function outputLindaForPHPError($errstr,$errfile,$errline) {
        if(isset($errfile)) {
            $file=file_get_contents($errfile);
            $file=explode("\n",$file);
            $array=array ();
            $line=$errline-1;
            if(strpos($errstr,"unexpected")!=false) {
                if(!strpos($file[$line],"}")) {
                    $errstr="syntax error, missing '}'";
                } else if(!strpos($file[$line],"{")) {
                    $errstr="syntax error, missing '{'";
                } else if(!strpos($file[$line],";")) {
                    $errstr="syntax error, missing ';'";
                }
            }
            $text=$errstr;
            for ($line-5 <= 0 ? $i=0 : $i=$line-5;$line+5>=count($file) ? $i<count($file) : $i<=$line+5;$i++) {
                if($i!=$line){
                    array_push($array,"<span style='font-size: 10px;padding-right:10px'>".$i."</span>".$file[$i]);
                } else {
                    array_push($array,"<span style='font-size: 10px;padding-right:10px;color:red;'>".$i."</span><b style='color:red;'>".$file[$i]."</b>");
                }
            }
            include DIR_LIBS."/Debug/LindaLayout.php";
        }
    }

    /**
     * Shows the debugbar.
     * @param int $start
     */
    public static function showDebugBar($start) {

        $executionTime = 0;
        if (isset($_SERVER["REQUEST_TIME_FLOAT"])) {
            $executionTime = microtime(TRUE) - $_SERVER["REQUEST_TIME_FLOAT"];
        } else {
            $executionTime = microtime(TRUE) - $start;
        }
        $executionTime = round($executionTime * 1000, 2);

        if(!Request::getInstance()->isAjax()) {

            $res = Response::getInstance();

            $res->append("<div id='linda' style='sans-serif;color: #333;border: 1px solid #c9c9c9;background: #EDEAE0;position: fixed;right: 0;bottom: 0;overflow: auto;min-height: 21px;min-width: 50px;white-space: nowrap;z-index: 30000;opacity: .9;transition: opacity 0.2s;border-radius: 3px;box-shadow: 1px 1px 10px;cursor:pointer;'>");
            $res->append("<ul style='list-style: none none;margin-left: 4px;clear: left;'>");
            $res->append("<li style='margin-left: -35px;float:left'><b>EOSS</b></li>");
            $res->append("<li class='exec-time' style='padding-left: 20px; float:left'>" . $executionTime . "ms</li>");
            $res->append("<li class='alloc-memory' style='padding-left: 20px; float:left'>" . round(memory_get_peak_usage(TRUE) / 1000000, 2) . "MB</li>");
            $res->append("</ul>");
            $res->append("</div>");
            $res->flush();
        } else {
            self::updateDebugBar($executionTime);
        }
    }

    public static function updateDebugBar($execTime) {
        $res = Response::getInstance();

        $res->append("$('#linda').find('.exec-time').html(\"" . $execTime . "ms\");\n", FALSE);
        $res->append("$('#linda').find('.alloc-memory').html(\"" . round(memory_get_peak_usage(TRUE) / 1000000, 2) . "MB\");\n", FALSE);
    }

    /**
     * Dumps the data passed as $var.
     * @param mixed $var
     */
    public static function dd($var) {
        echo "<br>";
        if($var == FALSE || $var == NULL) {
            echo "FALSE or NULL";
        } else {
            print_r($var);
        }
        echo "<br>";
    }
}
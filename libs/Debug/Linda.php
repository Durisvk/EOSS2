<?php
namespace Debug;

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
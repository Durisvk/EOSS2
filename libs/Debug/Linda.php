<?php
namespace Debug;

use Http\Request;
use Http\Response;
use \Utils\File;
/**
 * The class is created to display the debug information such as Errors, ...
 *
 * @author Juraj Čarnogurský
 * Class Linda
 * @package Debug\Linda
 */
class Linda {

    /**
     * Dumped variables.
     * @var string
     */
    private static $dumped = "";


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

            $res->append("<div class='EOSS-dumped' style='position: absolute;display: none;width: 300px;height: 500px;background-color: #f5f5f5;box-shadow: 1px 1px 10px;'>" . self::$dumped . "</div>");
            $res->append("<div id='EOSS-linda' style='width: 300px; height: 22px;sans-serif;color: #333;border: 1px solid #c9c9c9;background: #EDEAE0;position: fixed;right: 0;bottom: 0;overflow: auto;min-height: 21px;min-width: 50px;white-space: nowrap;z-index: 30000;opacity: .9;transition: opacity 0.2s;border-radius: 3px;box-shadow: 1px 1px 10px;cursor:pointer;'>");
            $res->append("<ul style='list-style: none none;margin-left: 4px;clear: left;'>");
            $res->append("<li style='margin-left: -35px;float:left'><b>EOSS</b></li>");
            $res->append("<li class='EOSS-exec-time' style='padding-left: 20px; float:left'>" . $executionTime . "ms</li>");
            $res->append("<li class='EOSS-alloc-memory' style='padding-left: 20px; float:left'>" . round(memory_get_peak_usage(TRUE) / 1000000, 2) . "MB</li>");
            $res->append("<li class='EOSS-variables' style='padding-left: 20px; float:left'>variables &#9650;</li>");
            $res->append("</ul>");
            $res->append("</div>");

            $res->append("
                <script>
                function handle_mousedown(e){
                    window.my_dragging = {};
                    my_dragging.pageX0 = e.pageX;
                    my_dragging.pageY0 = e.pageY;
                    my_dragging.elem = this;
                    my_dragging.offset0 = $(this).offset();
                    function handle_dragging(e){
                        var left = my_dragging.offset0.left + (e.pageX - my_dragging.pageX0);
                        var top = my_dragging.offset0.top + (e.pageY - my_dragging.pageY0);
                        $(my_dragging.elem)
                        .offset({top: top, left: left});
                    }
                    function handle_mouseup(e){
                        $('body')
                        .off('mousemove', handle_dragging)
                        .off('mouseup', handle_mouseup);
                    }
                    $('body')
                    .on('mouseup', handle_mouseup)
                    .on('mousemove', handle_dragging);
                }
                $('#EOSS-linda').mousedown(handle_mousedown);
                $('#EOSS-linda').find('.EOSS-variables').hover(function() {
                    $('.EOSS-dumped').fadeIn();
                  }, function() {
                    $('.EOSS-dumped').fadeOut();
                  });
                 $('#EOSS-linda .EOSS-variables').on('mousemove', function(event) {
                     var left = event.pageX - 302;
                     var top = event.pageY - 502;
                     
                     $('.EOSS-dumped').css({top: top,left: left});
                 });
                </script>
            ");
            $res->flush();
        } else {
            self::updateDebugBar($executionTime);
        }
    }

    public static function updateDebugBar($execTime) {
        $res = Response::getInstance();

        $res->append("$('#EOSS-linda').find('.EOSS-exec-time').html(\"" . $execTime . "ms\");\n", FALSE);
        $res->append("$('#EOSS-linda').find('.EOSS-alloc-memory').html(\"" . round(memory_get_peak_usage(TRUE) / 1000000, 2) . "MB\");\n", FALSE);
        $res->append("$('.EOSS-dumped').html(`" . self::$dumped . "`)", FALSE);
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
            $str = print_r($var, TRUE);
            echo htmlspecialchars($str);
        }
        echo "<br>";
    }

    /**
     * Dumps the variable to the debug bar.
     * @param mixed $var
     */
    public static function dump($var) {
        self::$dumped .= print_r($var, TRUE) . "<br><br>";
        self::$dumped = htmlspecialchars(self::$dumped);
    }
}
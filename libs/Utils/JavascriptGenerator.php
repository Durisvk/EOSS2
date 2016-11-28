<?php

namespace Utils;


use Application\Config;
use Debug\Linda;
use EOSS\EOSS;
use Http\Response;

/**
 * Gnerates ajax communication for EOSS to work.
 * @static Class JavascriptGenerator
 * @package Utils
 */
class JavascriptGenerator
{

    /**
     * Generates the core functionality and stores it into js file
     * @param EOSS $eoss
     */
    public static function generateJavascript(EOSS $eoss) {
        $js="";
        foreach($eoss->csi as $key=>$attr) {
            if($attr != NULL && $key != 'params' && $key != 'intervals') { // Filter params and intervals from CSI
                $js .= self::checkForEvents($attr, get_class($eoss));
            }
        }
        $js .= self::generateIntervals($eoss->csi->intervals, get_class($eoss));
        $genjs=fopen(DIR_TEMP . "data/genJs/".get_class($eoss).".js", "w") or die("Check out your permissions on file libs/data/!");
        fwrite($genjs, $js);
        fclose($genjs);
    }


    /**
     * Checks for all of the events and generates the javascript to handle them.
     * @param array $attr
     * @param string $class
     * @return string
     */
    public static function checkForEvents($attr,$class) {
        $listOfProp=json_decode(file_get_contents(DIR_LIBS."EOSS/eventList.json"));
        $js="";
        foreach ($listOfProp as $key=>$prop) {
            if($attr && property_exists($attr,$key)) {
                $e=false;
                if(strpos($prop,":")!=false) {
                    $e=true;
                    $s=explode(":",$prop);
                    $prop=$s[0];
                    $param=$s[1];
                }
                $js.="$( '#".$attr->id."' ).on('".$prop."',function (";
                $e ? $js.="event" : $js.="";
                $js.=") {\n";
                $js.="$.get('" . URL_LIBS . "request.php',{'eoss':'".$class."','id':'".$attr->id."','event':'".$key."','values':createJSON()";
                $e ? $js.=",'param': event.".$param.", curValue:$(this).val()+String.fromCharCode(event.keyCode)" : $js.="";
                $js.="}, function (data) {
                                " . (Config::getParam("enviroment") == "debug" ? "console.log(data);" : "") . "
								eval(data);
								".$attr->id.$key."(data);
							});
						});";
            }
        }
        return $js;
    }


    /**
     * @param array $intervals
     * @param string $class
     * @return string
     */
    public static function generateIntervals($intervals, $class) {
        $js = "\n\n";
        foreach($intervals as $key => $value) {
            $js .= "setInterval(function() {\n";
            $js.="$.get('" . URL_LIBS . "request.php',{'eoss':'".$class."','event':'".$key."','values':createJSON()";
            $js.="}, function (data) {
                        " . (Config::getParam("enviroment") == "debug" ? "console.log(data);" : "") . "
                        eval(data);
                        ".$key."Interval(data);
                    });
                }, " . $value . ");";
        }
        return $js;
    }

    /**
     * Writes a response into genFunctions.js file.
     * @param EOSS $eoss
     * @param string $fname
     */
    public static function writeJsResponse(EOSS $eoss, $fname) {
        $listOfAttr=json_decode(file_get_contents(DIR_LIBS."EOSS/attributeList.json"));
        $js="function ".$fname."() {";
        if(!isset($eoss->redirect)) {
            foreach (get_object_vars($eoss->csi) as $element) {
                if(is_array($element)) continue;
                foreach($listOfAttr as $key=>$attr) {
                    if ($element && property_exists($element, $key)) {

                        if($key != "html" && $key != "value") {
                            $js .= "$( '#" . $element->id . "' ).attr(\"" . str_replace("_", "-", $key) . "\", '";
                        } else if($key == "html"){
                            $js .= "$( '#" . $element->id . "' ).html('";
                        } else if($key == "value") {
                            $js .= "$( '#" . $element->id . "' ).val('";
                        }
                        $js .= preg_replace("/\r|\n/", "", $element->$key);
                        $js .= "');\n";
                    }

                }
            }
        } else {
            $js.="location.reload();";
        }
        $js.="}";
        /*$genjs=fopen(DIR_TEMP . "data/genJs/genFunctions.js", "w") or die("Check out your permissions on file libs/data/!");
        fwrite($genjs, $js);
        fclose($genjs);*/
        Response::getInstance()->append($js, FALSE);
    }



}
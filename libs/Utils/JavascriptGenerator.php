<?php

namespace Utils;


use Application\Config;
use Binding\CollectionBinding;
use Binding\ElementBinding;
use Binding\PropertyBinding;
use EOSS\EOSS;
use Forms\Form;
use Http\Response;

/**
 * Generates ajax communication for EOSS to work.
 *
 * @author Juraj Čarnogurský
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
            if($attr != NULL && $key != 'params' && $key != 'intervals' && $key != 'bindings' && $key != 'events') { // Filter params and intervals from CSI
                $js .= self::checkForEvents($attr, get_class($eoss));
            }
        }
        $js .= self::generateEvents($eoss->csi->events, get_class($eoss));
        $js .= self::generateIntervals($eoss->csi->intervals, get_class($eoss));
        $js .= self::generateForms($eoss->getForms(), get_class($eoss));
        $js .= self::generateFlashes($eoss);
        $js .= self::generateBindings($eoss);
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
        $listOfEvents=json_decode(file_get_contents(DIR_LIBS."EOSS/eventList.json"));
        $js="";
        foreach ($listOfEvents as $key=>$prop) {
            $e=false;

            $param = "";
            if(strpos($prop,":")!=false) {
                $e=true;
                $s=explode(":",$prop);
                $prop=$s[0];
                $param=$s[1];
            }

            $condition = NULL;
            if(strpos($prop, "-")) {
                $s=explode("-", $prop);
                $prop = $s[0];
                $condition = $s[1];
            }
            if($attr && property_exists($attr,$key) && count($attr->$key) > 0 && (property_exists($attr, "type") && $attr->type != "group")) {
                // Generate single element events.
                $js.="\n$( '#".$attr->id."' ).on('".$prop."',function (";
                $js.="event";
                $js.=") {\n";
                $js.= $attr->type == "a" ? "event.preventDefault();\n" : "";
                $js.= $condition ? "if(" . $condition . ")\n\t" : "";
                $js.="$.post('" . URL_LIBS . "request.php',{'eoss':'".$class."','id':'".$attr->id."','event':'".$key."','values':createJSON()";
                $e ? $js.=",'param': event.".$param.", curValue:$(this).val()+String.fromCharCode(event.keyCode)" : $js.="";
                $js.="}, function (data) {
        " . (Config::getParam("enviroment") == "debug" ? "console.log(data);" : "") . "
        eval(data);
        ".$attr->id.$key."(data);
    });
});";
            } else if($attr && property_exists($attr,$key) && count($attr->$key) > 0 && (property_exists($attr, "type") && $attr->type == "group")) {
                // Generate group:
                $js.="\n\n$('body').on('{$prop}', '[data-group=\"" . $attr->id . "\"]', function (";
                $js.="event";
                $js.=") {\nvar $" . "self = $(event.target);\n";
                $js.="if($" . "self.is('a')) {\nevent.preventDefault()\n}\n";
                $js.="var data = {'eoss':'{$class}', 'id':'{$attr->id}', 'event':'{$key}','values':createJSON()";
                $e ? $js .= ",'param': event.{$param}, curValue:$(this).val()+String.fromCharCode(event.keyCode)" : $js.="";
                $js.="};\n";
                $js.="if(typeof $(this).attr(\"id\") == \"undefined\" || $(this).attr(\"id\") == \"\") {\n";
                $js .= "$(this).attr(\"id\", randomString(10));\n";
                $js .= "data.element_id = $(this).attr(\"id\"); \n";
                $js .= "data.anonymous = getAllAttributes($(this));\n";
                $js.="\n} else {\n data.element_id = $(this).attr('id'); \n}\n";
                $js.= $condition ? "if(" . $condition . ")\n\t" : "";
                $js.="$.post('" . URL_LIBS . "request.php', data, function (data) {
        " . (Config::getParam("enviroment") == "debug" ? "console.log(data);" : "") . "
        eval(data);
        ".$attr->id.$key."(data);
    });
    if($"."self.is('a')) return false;
});";
            }

        }
        return $js;
    }

    /**
     * Generates the Events javascript.
     * @param array $events
     * @param string $class
     * @return string
     */
    public static function generateEvents($events, $class) {
        $listOfEvents=JSON::decode(file_get_contents(DIR_LIBS."EOSS/eventList.json"));
        $js = "";
        foreach($events as $event) {

            $prop = $listOfEvents[$event["Event"]];

            $e=false;

            $param = "";
            if(strpos($prop,":")!=false) {
                $e=true;
                $s=explode(":",$prop);
                $prop=$s[0];
                $param=$s[1];
            }

            $condition = NULL;
            if(strpos($prop, "-")) {
                $s=explode("-", $prop);
                $prop = $s[0];
                $condition = $s[1];
            }

            $js.="\n\n$('body').on('{$prop}', \"[data-event=\\\"{$event["string"]}\\\"]\", function (";
            $js.="event";
            $js.=") {\nvar $" . "self = $(event.target);\n";
            $js.="if($" . "self.is('a')) {\nevent.preventDefault()\n}\n";
            $js.="var data = {'eoss':'{$class}', 'id':'anonymous', 'event':'{$event["Event"]}', 'action': '{$event["Action"]}','values':createJSON()";
            $e ? $js .= ",'param': event.{$param}, curValue:$(this).val()+String.fromCharCode(event.keyCode)" : $js.="";
            $js.="};\n";
            $js.="if(typeof $(this).attr(\"id\") == \"undefined\" || $(this).attr(\"id\") == \"\") {\n";
            $js .= "$(this).attr(\"id\", randomString(10));\n";
            $js .= "data.element_id = $(this).attr(\"id\"); \n";
            $js .= "data.anonymous = getAllAttributes($(this));\n";
            $js.="\n} else {\n data.element_id = $(this).attr('id'); \n}\n";
            $js.= $condition ? "if(" . $condition . ")\n\t" : "";
            $js.="$.post('" . URL_LIBS . "request.php', data, function (data) {
        " . (Config::getParam("enviroment") == "debug" ? "console.log(data);" : "") . "
        eval(data);
        anonymous{$event['Event']}(data);
    });
    if($"."self.is('a')) return false;
});";


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
            $js.="$.post('" . URL_LIBS . "request.php',{'eoss':'".$class."','event':'".$key."','values':createJSON()";
            $js.="}, function (data) {
        " . (Config::getParam("enviroment") == "debug" ? "console.log(data);" : "") . "
        eval(data);
        ".$key."Interval(data);
    });";
            $js .= "setInterval(function() {\n";
            $js.="$.post('" . URL_LIBS . "request.php',{'eoss':'".$class."','event':'".$key."','values':createJSON()";
            $js.="}, function (data) {
        " . (Config::getParam("enviroment") == "debug" ? "console.log(data);" : "") . "
        eval(data);
        ".$key."Interval(data);
    });
}, " . $value . ");";
        }
        return $js;
    }

    public static function generateForms($forms, $class) {
        $js = "\n\n";
        /** @var Form $form */
        foreach($forms as $form) {
            $js .= "$( \"#{$form->getId()}\" ).on(\"submit\", function(event) {\n";
            $js .= "event.preventDefault();\n";
            $js .= "var formData = new FormData($(this)[0]);\n";
            $js .= "formData.append(\"eoss\", \"{$class}\");\n";
            $js .= "formData.append(\"form\", \"{$form->getName()}\");\n";
            $js .= "formData.append(\"values\", createJSON());\n";
            $js .= " $.ajax({
        url: $(this).attr('action'),
        type: \"POST\",
        data: formData,
        success: function(data) {
            " . (Config::getParam("enviroment") == "debug" ? "console.log(data);" : "") . "
            eval(data);
            {$form->getName()}Form(data);
        },
        processData: false,
        contentType: false
    }); ";

            $js.="return false";
            $js.="});";
        }
        return $js;

    }

    /**
     * Generates the javascript for flash messages.
     * @param EOSS $eoss
     * @return string
     */
    public static function generateFlashes(EOSS $eoss) {
        $js = "";
        if(Config::getParam("showFlashFunction") && $eoss->getCountOfFlashMessages() > 0) {
            $js .= "if(typeof " . Config::getParam("showFlashFunction") . " == 'function') {\n";
            while($flash = $eoss->popFlashMessage()) {
                $js .= Config::getParam("showFlashFunction") . "(\"{$flash["message"]}\", \"{$flash["class"]}\");\n";
            }
            $js .= "}\n";
        }
        return $js;
    }

    /**
     * Generates the bingings javascript.
     * @param EOSS $eoss
     * @return string
     */
    public static function generateBindings(EOSS $eoss) {
        $js = "";
        foreach($eoss->csi->bindings as $binding) {
            if($binding instanceof ElementBinding) {
                $js .= $binding->initialBindingJavascript();
                $js .= "$( \"[data-binding=\\\"{$binding->getString()}\\\"]\" ).on('click mousedown mouseup focus blur input change', function(e) {\n";
                $js .= $binding->getJavascriptAction() . "\n";
                $js .= "\n});";

                if($binding->getMode() == 'two-way') {
                    $js .= "$( '{$binding->getSourceElement()}' ).on('click mousedown mouseup focus blur input change', function(e) {\n";
                    $js .= $binding->getJavascriptSecondWay() . "\n";
                    $js .= "\n});\n";
                }
            } else if($binding instanceof PropertyBinding) {
                $js .= $binding->initialJavascript($eoss) . "\n\n";
            } else if($binding instanceof CollectionBinding) {
                $js .= $binding->getJavascript($eoss) . "\n\n";
            }
        }

        return $js;
    }

    /**
     * Writes a response into genFunctions.js file.
     * @param EOSS $eoss
     * @param string $fname
     * @param array $changed
     * @param null|\EOSS\AnonymousSender $anonymousSender
     */
    public static function writeJsResponse(EOSS $eoss, $fname, $changed = array(), $anonymousSender = NULL) {
        $listOfAttr=json_decode(file_get_contents(DIR_LIBS."EOSS/attributeList.json"));
        $js="function ".$fname."() {\n";
        if(!isset($eoss->redirect)) {
            foreach ($changed as $element) {
                if(is_array($element)) continue;
                foreach($listOfAttr as $key=>$attr) {
                    if ($element && property_exists($element, $key)) {

                        if($key != "html" && $key != "value") {
                            $js .= "$( '#" . $element->id . "' ).attr(\"" . str_replace("_", "-", $key) . "\", \"";
                        } else if($key == "html"){
                            $js .= "$( '#" . $element->id . "' ).html(\"";
                        } else if($key == "value") {
                            $js .= "$( '#" . $element->id . "' ).val(\"";
                        }
                        $str = preg_replace("/\r|\n/", "", $element->$key);
                        $str = str_replace("\\\"", "\"", $str);
                        $str = str_replace("\"", "\\\"", $str);
                        $js .= $str;
                        $js .= "\");\n";
                    }

                }
            }
            if($anonymousSender) {
                foreach($listOfAttr as $key=>$attr) {
                    if (key_exists($key, $anonymousSender->toArray())) {
                        if($key != "html" && $key != "value") {
                            $js .= "$( '#" . $anonymousSender->id . "' ).attr(\"" . str_replace("_", "-", $key) . "\", \"";
                        } else if($key == "html"){
                            $js .= "$( '#" . $anonymousSender->id . "' ).html(\"";
                        } else if($key == "value") {
                            $js .= "$( '#" . $anonymousSender->id . "' ).val(\"";
                        }
                        $str = preg_replace("/\r|\n/", "", $anonymousSender->$key);
                        $str = str_replace("\\\"", "\"", $str);
                        $str = str_replace("\"", "\\\"", $str);
                        $js .= $str;
                        $js .= "\");\n";
                    }
                }
                $js .= "$( '#" . $anonymousSender->id . "' ).attr('id', \"\");\n";
            }
            $js .= self::generateFlashes($eoss);

            foreach($eoss->csi->bindings as $binding) {
                if($binding instanceof PropertyBinding) {
                    $js .= $binding->getResponseJavascript($eoss);
                } else if($binding instanceof CollectionBinding) {
                    $js .= $binding->getJavascript($eoss);
                }
            }

        } else {
            $js.="location.reload();";
        }
        $js.="}";
        Response::getInstance()->append($js, FALSE);
    }



}
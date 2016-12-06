<?php

namespace Utils;
use Debug\Linda;

/**
 * Static Helper class for HTML manipulations with DOMDocument
 * Class HTML
 * @package Utils
 */
class HTML
{

    /**
     * Returns the ids of DOM elements inside string.
     * @param string $str
     * @return array
     */
    public static function getIds($str) {
        $ids=array();
        preg_match_all('(id=\"[ a-zA-Z0-9_-]*\")',$str,$matches);
        foreach ($matches[0] as $match) {
            $id=explode("=",$match);
            array_push($ids,str_replace('"','',$id[1]));
        }
        return $ids;
    }

    /**
     * Gets the element by its id from DOMDocument
     * @param string $id
     * @param \DOMDocument $dom
     * @return mixed
     */
    public static function getElementById($id, $dom) {
        $xpath = new \DOMXPath($dom);
        return $xpath->query("//*[@id='$id']")->item(0);
    }


    /**
     * Returns the HTML of an element
     * @param \DOMNode $element
     * @return string
     */
    public static function getInnerHTML(\DOMNode $element)
    {
        $innerHTML = "";
        $children = $element->childNodes;
        foreach ($children as $child)
        {
            $tmp_dom = new \DOMDocument();
            $tmp_dom->appendChild($tmp_dom->importNode($child, true));
            $innerHTML.=trim($tmp_dom->saveHTML());
        }
        return $innerHTML;
    }

    /**
     * Gets the elements in JSON format from string in format of HTML
     * @param string $str
     * @return string
     */
    public static function getElements($str) {
        $ids=self::getIds($str);
        $dom=new \DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML($str);
        libxml_clear_errors();
        $elements=array();
        foreach ($ids as $id) {
            $elements[] =self::getElementById($id,$dom);
        }
        $attributes = array();
        $json='{';
        foreach ($elements as $el) {
            if(!$el) continue;
            $json.='"'.$el->getAttribute("id").'": {';
            foreach ($el->attributes as $name => $attr) {
                $json.= '"'.$name.'": "'.$attr->value.'"';
                $json.=', ';
            }
            if(!$el->getAttribute("type")) {
                $json .= '"type": "' . $el->tagName . '",';
            }
            $innerHtml=self::getInnerHTML($el);
            $innerHtml=str_replace('"', '\"', $innerHtml);
            //$innerHtml != "" ?  $json.='"html": "'.$innerHtml.'"' : $json=rtrim($json, ', ');
            $json .= '"html": "' . $innerHtml . '"';
            $json.='}';
            $json.=', ';
        }
        $json=rtrim($json, ', ');
        $json.='}';
        $json = trim(preg_replace('/\s+/', ' ', $json));
        return $json;
    }


    private static function getAttrWithNameOfNode(\DOMNode $domNode, &$array, $attrName) {
        /** @var \DOMNode $node */
        foreach($domNode->childNodes as $node) {
            if($node->attributes && $node->attributes->length > 0) {
                $attrValue = self::getAttribute($attrName, $node->attributes);
                if($attrValue) {
                    if(!in_array($attrValue, $array)) {
                        $array[] = $attrValue;
                    }
                }
            }
            if($node->hasChildNodes()) {
                self::getAttrWithNameOfNode($node, $array, $attrName);
            }
        }
    }

    public static function getAttribute($name, $att)
    {
        /** @var \DOMAttr $i */
        foreach($att as $i)
        {
            if($i->name==$name)
                return $i->value;
        }
        return NULL;
    }


    /**
     * Gets all the data-group attribute values.
     * @param string $str
     * @return array
     */
    public static function getGroups($str) {
        $dom=new \DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML($str);
        libxml_clear_errors();
        $groups = [];

        self::getAttrWithNameOfNode($dom, $groups, "data-group");

        return $groups;
    }

    public static function getBindings($str) {
        $dom=new \DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML($str);
        libxml_clear_errors();
        $bindings = [];

        self::getAttrWithNameOfNode($dom, $bindings, "data-binding");

        return $bindings;
    }

}
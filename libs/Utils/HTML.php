<?php

namespace Utils;

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
    static function getInnerHTML(\DOMNode $element)
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
        $dom->loadHTML($str);
        $elements=array();
        foreach ($ids as $id) {
            array_push($elements,self::getElementById($id,$dom));
        }
        $attributes = array();
        $json='{';
        foreach ($elements as $el) {
            $json.='"'.$el->getAttribute("id").'": {';
            foreach ($el->attributes as $name => $attr) {
                $json.= '"'.$name.'": "'.$attr->value.'"';
                $json.=', ';
            }
            $innerHtml=self::getInnerHTML($el);
            $innerHtml=str_replace('"', '\"', $innerHtml);
            $innerHtml != "" ?  $json.='"html": "'.$innerHtml.'"' : $json=rtrim($json, ', ');
            $json.='}';
            $json.=', ';
        }
        $json=rtrim($json, ', ');
        $json.='}';
        return $json;
    }

}
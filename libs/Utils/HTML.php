<?php

namespace Utils;
use Debug\Linda;

/**
 * Static Helper class for HTML manipulations with DOMDocument
 *
 * @author Juraj Čarnogurský
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
     * Gets the element by its id from DOMDocument.
     * @param string $id
     * @param \DOMDocument $dom
     * @return \DOMNode
     */
    public static function getElementById($id, $dom) {
        $xpath = new \DOMXPath($dom);
        return $xpath->query("//*[@id='$id']")->item(0);
    }


    /**
     * Returns the HTML of an element.
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
     * Sets the inner html of an element.
     * @param \DOMDocument $dom
     * @param \DOMNode $element
     * @param string $html_string
     */
    public static function setInnerHTML(\DOMDocument &$dom, \DOMNode &$element, $html_string) {
        $dom2 = new \DOMDocument();
        libxml_use_internal_errors(true);
        $dom2->loadHTML($html_string, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        libxml_clear_errors();
        $element->appendChild($dom->importNode($dom2->firstChild, TRUE));
    }

    /**
     * Gets the elements in JSON format from string in format of HTML.
     * @param \DOMDocument $dom
     * @param string $str
     * @return string
     */
    public static function getElements($dom, $str) {
        $ids=self::getIds($str);
        $elements=array();
        foreach ($ids as $id) {
            $elements[] =self::getElementById($id,$dom);
        }
        $json='{';
        foreach ($elements as $el) {
            if(!$el) continue;
            $json.='"'.$el->getAttribute("id").'": {';
            foreach ($el->attributes as $name => $attr) {
                $json.= '"'.str_replace("-", "_", $name).'": "'.$attr->value.'"';
                $json.=', ';
            }
            if(!$el->getAttribute("type")) {
                $json .= '"type": "' . $el->tagName . '",';
            }
            if($el->tagName == 'input' && !$el->getAttribute('value')) {
                $json .= '"value": "",';
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


    /**
     * Fills the array with attributes - values combination.
     * @param \DOMNode $domNode
     * @param array $array
     * @param string $attrName
     * @param bool $canBeMultiple
     */
    private static function getAttrWithNameOfNode(\DOMNode $domNode, &$array, $attrName, $canBeMultiple = TRUE) {
        /** @var \DOMNode $node */
        foreach($domNode->childNodes as $node) {
            if($node->attributes && $node->attributes->length > 0) {
                $attrValue = self::getAttribute($attrName, $node->attributes);
                if($attrValue) {
                    if(!$canBeMultiple) {
                        if (!in_array($attrValue, $array)) {
                            $array[] = $attrValue;
                        }
                    } else {
                        if($id = self::getAttribute("id", $node->attributes)) {
                            $array[] = ["id" => $id, $attrName => $attrValue];
                        } else {
                            $array[] = $attrValue;
                        }
                    }
                }
            }
            if($node->hasChildNodes()) {
                self::getAttrWithNameOfNode($node, $array, $attrName, $canBeMultiple);
            }
        }
    }

    /**
     * Gets an attribute from DOMNamedNodeMap of attributes with name.
     * @param string $name
     * @param \DOMNamedNodeMap $att
     * @return null|string
     */
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
     * @param \DOMNode $dom
     * @return array
     */
    public static function getGroups(\DOMNode $dom) {
        $groups = [];

        self::getAttrWithNameOfNode($dom, $groups, "data-group", FALSE);

        return $groups;
    }

    /**
     * Gets the elements with attribute data-binding.
     * @param \DOMNode $dom
     * @return array
     */
    public static function getBindings(\DOMNode $dom) {
        $bindings = [];

        self::getAttrWithNameOfNode($dom, $bindings, "data-binding");

        return $bindings;
    }

    /**
     * Gets the elements with attribute data-event.
     * @param \DOMNode $dom
     * @return array
     */
    public static function getEvents(\DOMNode $dom) {
        $events = [];
        self::getAttrWithNameOfNode($dom, $events, "data-event", FALSE);
        return $events;
    }

    /**
     * Gets the elements with attribute value.
     * @param \DOMDocument $domNode
     * @param string $attribute
     * @param string $value
     * @return \DOMNodeList
     */
    public static function getElementsByAttributeValue(\DOMDocument $domNode, $attribute, $value) {
        $xpath = new \DOMXPath($domNode);
        return $xpath->query("//*[@" . $attribute . "=\"" . $value . "\"]");
    }

    /**
     * Gets the element with attribute value.
     * @param \DOMDocument $domNode
     * @param string $attribute
     * @param string $value
     * @return \DOMNode
     */
    public static function getElementByAttributeValue(\DOMDocument $domNode, $attribute, $value) {
        return self::getElementsByAttributeValue($domNode, $attribute, $value)->item(0);
    }
}
<?php

namespace Tests\Utils;


use PHPUnit\Framework\TestCase;
use Utils\HTML;

class HTMLTest extends TestCase
{

    /**
     * @var \DOMDocument
     */
    private $dom;


    public function setUp() {
        $this->dom = new \DOMDocument();
        $this->dom->loadHTML("<div id='randomDiv1'><div data-binding='some binding'></div><div id='randomDiv2'><input id='randomText1' data-binding='some binding' type='text' /><b data-group='some group'>Some Content</b><b data-group='some group'>Some Content2</b><div id='randomDiv3' data-some-attribute='value'>content</div></div></div>");
    }

    public function testGetIds() {
        $ids = HTML::getIds($this->dom->saveHTML());

        $this->assertCount(4, $ids);
        $this->assertContains("randomDiv1", $ids);
        $this->assertContains("randomDiv2", $ids);
        $this->assertContains("randomDiv3", $ids);
        $this->assertContains("randomText1", $ids);
    }

    public function testGetElementById() {
        $element = HTML::getElementById("randomDiv3", $this->dom);
        $this->assertNotNull($element);
        $this->assertEquals("content", $element->nodeValue);
    }

    public function testGetInnerHTML() {
        $el = $this->dom->getElementById("randomDiv3");
        $this->assertEquals($el->textContent, HTML::getInnerHTML($el));
    }

    public function testGetElements() {
        $elements = HTML::getElements($this->dom, $this->dom->saveHTML());
        $elements = json_decode($elements, TRUE);
        $this->assertNotFalse($elements);
        $this->assertCount(4, $elements);
        $this->assertArrayHasKey("randomDiv1", $elements);
        $this->assertArrayHasKey("randomDiv2", $elements);
        $this->assertArrayHasKey("randomDiv3", $elements);
        $this->assertEquals("div", $elements["randomDiv1"]["type"]);
        $this->assertEquals("div", $elements["randomDiv2"]["type"]);
        $this->assertEquals("div", $elements["randomDiv3"]["type"]);
        $this->assertEquals("text", $elements["randomText1"]["type"]);
        $this->assertEquals("", $elements["randomText1"]["value"]);
    }

    public function testGetGroups() {
        $groups = HTML::getGroups($this->dom);

        $this->assertCount(1, $groups);
        $this->assertContains("some group", $groups);
    }

    public function testBindings() {
        $bindings = HTML::getBindings($this->dom);

        $this->assertCount(2, $bindings);
        $this->assertContains("some binding", $bindings);
        $this->assertArrayHasKey("id", $bindings[1]);
        $this->assertArrayHasKey("data-binding", $bindings[1]);
        $this->assertEquals("randomText1", $bindings[1]["id"]);
        $this->assertEquals("some binding", $bindings[1]["data-binding"]);
    }

    public function testGetElementByAttributeValue() {
        $el = HTML::getElementByAttributeValue($this->dom, "data-some-attribute", "value");
        $this->assertEquals("content", $el->nodeValue);
    }

}
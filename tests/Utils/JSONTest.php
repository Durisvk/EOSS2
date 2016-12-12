<?php

namespace Tests\Utils;


use PHPUnit\Framework\TestCase;
use Utils\JSON;

class JSONTest extends TestCase
{

    public function testValidJSON() {

        $this->assertNotFalse(JSON::decode("{ \"valid\": \"json\", \"this\": \"is\" }"));

        $this->assertTrue(isset(JSON::decode("{ \"valid\": \"json\", \"this\": \"is\" }")["valid"]));

        $this->assertArrayHasKey("this", JSON::decode("{ \"valid\": \"json\", \"this\": \"is\" }"));

        $this->assertInstanceOf("stdClass", JSON::decode("{ \"valid\": \"json\", \"this\": \"is\" }", FALSE));

        $this->assertObjectHasAttribute("this", JSON::decode("{ \"valid\": \"json\", \"this\": \"is\" }", FALSE));
    }

    public function testFormattableJSON() {

        $this->assertNotFalse(JSON::decode(" valid: \"json\", this: \"is\" "));

        $this->assertArrayHasKey("valid", JSON::decode(" valid: \"json\", this: \"is\" "));

        $this->assertObjectHasAttribute("this", JSON::decode("valid: \"json\", this: \"is\"", FALSE));

        $this->assertArrayHasKey("this", JSON::decode("{ valid: \"json\", this: \"is\" }"));

        $this->assertEquals(5, JSON::decode(5));

        $this->assertEquals(-1, JSON::decode(-1));

    }

    public function testInvalidJSON() {

        $this->assertNull(JSON::decode("valid: json, this: is"));

        $this->assertNull(JSON::decode("asdf"));

    }
}
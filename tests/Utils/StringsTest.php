<?php

namespace Tests\Utils;


use PHPUnit\Framework\TestCase;
use Utils\Strings;

class StringsTest extends TestCase
{

    public function testStartsWith() {
        $this->assertTrue(Strings::startsWith("thisIsJustATestString", "thisIs"));
        $this->assertFalse(Strings::startsWith("thisIsJustATestString", "asdf"));
    }

    public function testEndsWith() {
        $this->assertTrue(Strings::endsWith("thisIsJustATestString", "TestString"));
        $this->assertTrue(Strings::endsWith("thisIsJustATestString", ""));
        $this->assertFalse(Strings::startsWith("thisIsJustATestString", "asdf"));
    }

    public function testGenerateRandom() {
        $strings = [];
        for($i = 0; $i < 100; $i++) {
            $string = Strings::generateRandom(20);
            $this->assertNotContains($string, $strings);
            $strings[] = $string;
        }
    }

}
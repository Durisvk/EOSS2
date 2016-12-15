<?php

namespace Tests\Utils;


use PHPUnit\Framework\TestCase;
use Utils\File;

class FileTest extends TestCase
{

    public function testLineNumber() {
        $this->assertEquals(2, File::getLine("Hello World", ["Hey there,", " Hello people, ", "and Hello World, ", "How are You?"]));
        $this->assertEquals(2, File::getLine("Hello World", "Hey there,\n Hello people, \nand Hello World, \nHow are You?"));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testLineNumberException() {
        File::getLine(23, "Hey there,\n Hello people, \nand Hello World, \nHow are You?");
    }

    public function testFileSave() {
        File::save(TESTS_TEMP_PATH . "fileTest.txt", "this is the random text");
        $this->assertFileExists(TESTS_TEMP_PATH . "fileTest.txt");
    }

}
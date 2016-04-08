<?php

use IshyEvandro\Converter;

Class ConverterTest extends PHPUnit_Framework_TestCase
{

    protected $Converter;
    protected $path = __DIR__.'/files/';

    public function setUp()
    {
        $this->Converter = new Converter();
    }

    public function testCreateTextFromImageShouldReturnFalseWhenResourceNotExist()
    {
        $this->assertFalse($this->Converter->createTextFromImage($this->path,'not_exist', "not_created"));
    }

    public function testCreateTextFromImageShouldReturnTrueWhenFileExist()
    {
        $this->assertTrue($this->Converter->createTextFromImage($this->path,'tentativa_2.png', "test_generate.txt"));
        $this->assertTrue(file_exists($this->path.'test_generate.txt'));
        unlink($this->path.'test_generate.txt');
    }


    public function testCreateImageFromTextShouldReturnFalseWhenFileNotExist()
    {
        $this->assertFalse($this->Converter->createImageFromText($this->path,'not_exist', "not_created", [4,4]));
    }

    public function testCreateImageFromTextShouldReturnTrueAndCreateAnImage()
    {
        $this->assertTrue($this->Converter->createImageFromText($this->path,'four_mult_path.txt', "test_create_image.png", [4,4]));
         $this->assertTrue(file_exists($this->path.'test_create_image.png'));
        unlink($this->path.'test_create_image.png');   
    }

}

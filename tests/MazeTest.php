<?php

use IshyEvandro\Maze;

Class MazeTest extends PHPUnit_Framework_TestCase
{
    public $Maze;
    public $FileContent;
    
    public function setUp()
    {
        $this->Maze = new Maze();
        $this->FileContent = file_get_contents(__DIR__."/files/four.txt");
    }

    public function testSetSizeShouldReturnTrueWhenIntegerGreaterThanZeroPassed()
    {
        $this->assertTrue($this->Maze->setSize(2,2));
    }

    public function testSetSizeShouldReturnFalseWhenZeroPassed()
    {
        $this->assertFalse($this->Maze->setSize(0,0));
    }

    public function testSetSizeShouldReturnFalseWhenFloatPassed()
    {
        $this->assertFalse($this->Maze->setSize(1.1, 0));
    }

    public function testSetSizeShouldReturnFalseWhenStringPassed()
    {
        $this->assertFalse($this->Maze->setSize("asd", 0));
    }

    public function testCreateShouldReturnTrueWhenSizeWasSetted()
    {
        $this->Maze->setSize(4, 4);
        $this->assertTrue($this->Maze->create($this->FileContent));
    }

    public function testCreateShouldReturnFalseWhenSizeNotSetted()
    {
        try
        {
            $this->Maze->create($this->FileContent);
            $this->assertTrue(False);
        }
        catch(\Exception $e)
        {
            $this->assertTrue(True);
            $this->assertEquals("Size cant be zero", $e->getMessage());
        }
    }

    public function testCreateShouldReturnFalseWhenSizeOfResourceNotMatchWithMazeSize()
    {
        try
        {
            $this->Maze->setSize(4, 4);
            $this->Maze->create($this->FileContent."asd");
            $this->assertTrue(False);
        }
        catch(\Exception $e)
        {
            $this->assertTrue(True);
            $this->assertEquals("Resource size not match with maze size", $e->getMessage());
        }
    }

    public function testGetShouldReturnMatrix()
    {
        $this->Maze->setSize(4, 4);
        $this->Maze->create($this->FileContent);
        $this->assertEquals([['S',1,1,'F'],[0,1,1,0],[0,1,1,0], [0,0,0,0]], $this->Maze->get());
    }

    public function testGetStartPositionShouldReturnArray()
    {
        $this->Maze->setSize(4, 4);
        $this->Maze->create($this->FileContent);
        $this->assertEquals([0,0], $this->Maze->getStartPosition());
    }

    public function testGetFinishPositionShouldReturnArray()
    {
        $this->Maze->setSize(4, 4);
        $this->Maze->create($this->FileContent);
        $this->assertEquals([0,3], $this->Maze->getFinishPosition());
    }

    public function testGetStartPositionShouldThrowException()
    {
        $this->Maze->setSize(4, 4);
        $this->Maze->create(file_get_contents(__DIR__.'/files/four_err.txt'));
        try
        {
            $this->Maze->getStartPosition();
            $this->assertEquals("Should not enter here", "");
        }
        catch (\Exception $e)
        {
            $this->assertTrue(True);
            $this->assertEquals('Start position not found', $e->getMessage());
        }
    
    }

    public function testGetFinishPositionShouldThrowException()
    {
        $this->Maze->setSize(4, 4);
        $this->Maze->create(file_get_contents(__DIR__.'/files/four_err.txt'));
        try
        {
            $this->Maze->getFinishPosition();
            $this->assertEquals("Should not enter here", "");
        }
        catch (\Exception $e)
        {
            $this->assertTrue(True);
            $this->assertEquals('Finish position not found', $e->getMessage());
        }
    }
}

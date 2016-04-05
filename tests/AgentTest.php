<?php

use IshyEvandro\Agent;
use IshyEvandro\Maze;

Class AgentTest extends PHPUnit_Framework_TestCase
{
    public $Agent;
    public $Maze;
    
    public function setUp()
    {
        $this->Maze = new Maze();
        $this->Maze->setSize(4);
        $this->Maze->create(file_get_contents(__DIR__.'/files/four.txt'));
        $this->Agent = new Agent($this->Maze);
    }

    public function testSetStartAndFinishShouldReturnTrue()
    {
        $this->assertTrue($this->Agent->checkStartAndFinish());
    }

    public function testInitShouldReturnFirstPosition()
    {
        $this->assertEquals([0,0],$this->Agent->init());
    }

    public function testWalkShouldReturnTrueWhenHaveOptionInMaze()
    {
        $this->Agent->init();
        $this->assertTrue($this->Agent->walk());
        $this->assertEquals([1,0], $this->Agent->currentPosition);
    }

    public function testWalkShouldGoToGoal()
    {
        $this->Agent->init();
        for($i = 0; $i < 16; $i++)
        {
            $this->Agent->walk();   
        }
        $this->assertTrue($this->Agent->Goal);
        $this->assertEquals(
            [
                [0,0],
                [1,0],
                [2,0],
                [3,0],
                [3,1],
                [3,2],
                [3,3],
                [2,3],
                [1,3],
                [0,3]
            ], $this->Agent->pathToGoal()
        );
    }
}

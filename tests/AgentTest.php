<?php

use IshyEvandro\Agent;
use IshyEvandro\Maze;

Class AgentTest extends PHPUnit_Framework_TestCase
{
    public $Agent;
    public $Maze;
    
    public function setUp()
    {
        $resource = file_get_contents(__DIR__.'/files/four.txt');
        $this->initElements($resource);
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
        while($this->Agent->checkGoal() === 0)
            $this->Agent->walk();
        $this->assertEquals(1,$this->Agent->checkGoal());
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
            ], $this->Agent->getPathToGoal()
        );
    }

    public function testWalkShouldGoToGoalWhenHaveWrongPossiblePath()
    {
        $resource = file_get_contents(__DIR__.'/files/four_mult_path.txt');
        $this->initElements($resource);
        $this->Agent->init();
        for($i=0; $i < 2; $i++)
        {
            $this->Agent->walk();
        }

        $this->assertEquals(
            [
                [0,0],
                [1,0],
                [1,1]
            ], $this->Agent->getPathToGoal()
        );
    }

    public function testWalkShouldGoToGoalWithoutCrossAWalkedPath()
    {
        $resource = file_get_contents(__DIR__.'/files/four_mult_path.txt');
        $this->initElements($resource);
        $this->Agent->init();
        while($this->Agent->checkGoal() === 0)
        {
            $this->Agent->walk();
        }

        $this->assertEquals(
            [
                [0,0],
                [1,0],
                [1,1],
                [1,2],
                [0,2]
            ], $this->Agent->getPathToGoal()
        );
    }

    public function testcheckGoalShouldReturnNegativeNumber()
    {
        $resource = "S11F111111111111";
        $this->initElements($resource);
        $this->Agent->init();
        while($this->Agent->checkGoal() === 0)
            $this->assertFalse($this->Agent->Walk());
        $this->assertEquals(-1, $this->Agent->checkGoal());
        $this->assertEquals("Not found a path to goal", $this->Agent->getMessage());
    }

    public function testPrintResult()
    {
        $resource = file_get_contents(__DIR__.'/files/four_mult_path.txt');
        $this->initElements($resource);
        $this->Agent->init();
        while($this->Agent->checkGoal() === 0)
            $this->Agent->Walk();

        $this->assertEquals(
            "#1#1\n###0\n0100\n1001\n",
            $this->Agent->printResult()
        );
    }

    protected function initElements($resource)
    {
        $this->Maze = new Maze();
        $this->Maze->setSize(4, 4);
        $this->Maze->create($resource);
        $this->Agent = new Agent($this->Maze);
    }
}

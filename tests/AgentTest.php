<?php

use IshyEvandro\Agent;
use IshyEvandro\Maze;

Class AgentTest extends PHPUnit_Framework_TestCase
{
    public $Agent;
    
    public function setUp()
    {
        $this->maze = new Maze();
        $this->maze->setSize(4);
        $this->maze->create(file_get_contents(__DIR__.'/files/four.txt'));
        $this->Agent = new Agent();
    }

    public function testWalkShouldReturnTrueWhenHaveOptionInMaze()
    {
        $this->assertTrue($this->Agent->Walk());
    }

}
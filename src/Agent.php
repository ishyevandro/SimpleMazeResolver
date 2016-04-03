<?php

namespace IshyEvandro;

Class Agent
{

    private $startPosition = [];
    private $finishPosition = [];
    public $currentPosition = [];
    public $lastPosition = [-1,-1];
    public $path = [];
    public $Goal = false;
    public function __construct(Maze $maze)
    {
        $this->Maze = $maze;
    }

    public function walk()
    {
        if($this->walkLeft()  || 
           $this->walkRight() || 
           $this->walkDown()  || 
           $this->walkUp())
            return True;

        return False;
    }

    public function init()
    {
        $this->mazeSize = $this->Maze->getSize();
        $this->checkStartAndFinish();
        $this->currentPosition = $this->startPosition;
        $this->maze = $this->Maze->get();
        return $this->currentPosition;
    }

    public function checkStartAndFinish()
    {
        $this->startPosition = $this->Maze->getStartPosition();
        $this->finishPosition = $this->Maze->getFinishPosition();
        return True;
    }

    public function pathToGoal()
    {
        return array_merge($this->path, [$this->currentPosition]);
    }

    private function walkLeft()
    {
        list($x,$y) = $this->getPosition(-1,0);
        $this->tryWalk($x, $y);
    }

    private function walkRight()
    {
        list($x,$y) = $this->getPosition(1,0);
        return $this->tryWalk($x, $y);    
    }

    private function walkUp()
    {
        list($x,$y) = $this->getPosition(0,-1);
        return $this->tryWalk($x, $y);
    }

    private function walkDown()
    {
        list($x,$y) = $this->getPosition(0, 1);
        return $this->tryWalk($x, $y);
    }

    private function tryWalk($x, $y)
    {
        if($x < 0)
            return False;

        if($this->positionOpen($x, $y) && $this->notLastPosition($x, $y))
        {
            $this->newPosition($x, $y);
            return True; 
        }

        return False;
    }

    private function getPosition($x, $y)
    {
        $positionX = $this->currentPosition[0]+$x;
        $positionY = $this->currentPosition[1]+$y;
        if($positionX < 0 || $positionY < 0)
            return [-1, -1];

        if($positionX >= $this->mazeSize || $positionY >= $this->mazeSize)
            return [-1,-1];

        return [$positionX, $positionY];
    }

    private function positionOpen($x, $y)
    {
        if($this->maze[$x][$y] == 'F')
        {
            $this->Goal = True;
            return True;
        }
        if($this->maze[$x][$y] == 0)
            return True;

        return False;
    }

    private function notLastPosition($x, $y)
    {
        if($this->lastPosition[0] != $x || $this->lastPosition[1] != $y)
            return True;

        return False;
    }

    private function newPosition($x, $y)
    {
        $this->path[] = $this->currentPosition;
        $this->lastPosition = $this->currentPosition;
        $this->currentPosition = [$x, $y];
    }

}

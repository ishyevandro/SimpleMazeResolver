<?php

namespace IshyEvandro;

Class Agent
{

    private $startPosition = [];
    private $finishPosition = [];
    public $currentPosition = [];
    public $lastPosition = [-1,-1];
    public $path = [];
    public $Goal = 0;

    public function __construct(Maze $maze)
    {
        $this->Maze = $maze;
    }

    public function walk()
    {
        if($this->walkLeft() || $this->walkRight() || 
           $this->walkDown() || $this->walkUp())
            return True;

        $this->goBack();
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

    public function checkGoal()
    {
        return $this->Goal;
    }

    public function getPathToGoal()
    {
        return array_merge($this->path, [$this->currentPosition]);
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function printResult()
    {
        $result = $this->Maze->get();
        $path = $this->getPathToGoal();
        $pathSize = count($path);
        for($i=0;$i< $pathSize; $i++)
        {
            list($x, $y) = $path[$i];
            $result[$x][$y] = '#';
        }

        $lines = count($result);
        $solved = '';
        
        for($i=0; $i < $lines; $i++)
        {
            $solved .= implode('',$result[$i]);
            $solved .= "\n";
        }
        return $solved;
    }

    private function walkLeft()
    {
        list($x,$y) = $this->getPosition(0,-1);
        $this->tryWalk($x, $y);
    }

    private function walkRight()
    {
        list($x,$y) = $this->getPosition(0,1);
        return $this->tryWalk($x, $y);    
    }

    private function walkUp()
    {
        list($x,$y) = $this->getPosition(-1,0);
        return $this->tryWalk($x, $y);
    }

    private function walkDown()
    {
        list($x,$y) = $this->getPosition(1,0);
        return $this->tryWalk($x, $y);
    }

    private function tryWalk($x, $y)
    {
        if($x < 0)
            return False;

        if($this->positionOpen($x, $y) && $this->notLastPosition($x, $y) && !$this->walkedPosition($x, $y))
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

        if($positionX >= $this->mazeSize[0] || $positionY >= $this->mazeSize[1])
            return [-1,-1];

        return [$positionX, $positionY];
    }

    private function positionOpen($x, $y)
    {
        if($this->maze[$x][$y] == 'F')
        {
            $this->Goal = 1;
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
    
    private function goBack()
    {
        if(empty($this->path))
        {
            $this->Goal = -1;
            $this->message = "Not found a path to goal";
            return False;
        }
        $this->maze[$this->currentPosition[0]][$this->currentPosition[1]] = 1;
        $this->currentPosition = array_pop($this->path);
        if(empty($this->path))
            $this->lastPosition = [-1,-1];
        else
            $this->lastPosition = $this->path[(count($this->path)-1)];
        return True;
    }

    private function walkedPosition($x, $y)
    {
        if(in_array([$x,$y], $this->path))
            return True;

        return False;
    }
}

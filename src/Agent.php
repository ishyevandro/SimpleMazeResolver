<?php

namespace IshyEvandro;

Class Agent
{
    public $currentPosition = [];
    public $lastPosition = [-1,-1];

    protected $startPosition = [];
    protected $finishPosition = [];
    protected $mazeSize;
    protected $path = [];
    protected $Goal = 0;
    protected $message = '';

    /**
     * construct
     *
     * @param Maze $maze
     *
     */
    public function __construct(Maze $maze)
    {
        $this->Maze = $maze;
    }

    /**
     * Init elements to Agent, like save a maze in object, getStart and finish position
     * and get size of maze
     *
     * @return [] $this->currentPosition
     *
     */
    public function init()
    {
        $this->mazeSize = $this->Maze->getSize();
        $this->checkStartAndFinish();
        $this->currentPosition = $this->startPosition;
        $this->maze = $this->Maze->get();
        return $this->currentPosition;
    }

    /**
     * proccess agent telling him to go somewhere
     *
     * @return boolean
     */
    public function walk()
    {
        if($this->walkDirection(0,-1) || $this->walkDirection(0,1) || 
           $this->walkDirection(-1,0) || $this->walkDirection(1,0))
            return true;

        $this->goBack();
        return false;
    }

    /**
     * return an integer telling if goal was achieved, failed or in progress
     * -1 -> Failed
     *  0 -> Progress
     *  1 -> achieved
     *
     * @return integer $this->Goal
     */
    public function checkGoal()
    {
        return $this->Goal;
    }

    /**
     * return path to goal. Should be used only when goal is achieved
     *
     * @return [] $this->path + $this->currentPosition
     */
    public function getPathToGoal()
    {
        return array_merge($this->path, [$this->currentPosition]);
    }

    /**
     * Return the maze modified by agent
     *
     * @return [$this->mazeSize[0]][$this->mazeSize[1]] $this->maze
     */
    public function getMaze()
    {
        return $this->maze;
    }

    /**
     * return message, should be used only whe goal is not achieved
     *
     * @return string $this->message
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * return the result of maze in string type
     *
     * @return string $solved
     */
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

    /**
     * get from maze class start and finish position
     *
     * @return boolean
     */
    protected function checkStartAndFinish()
    {
        $this->startPosition = $this->Maze->getStartPosition();
        $this->finishPosition = $this->Maze->getFinishPosition();
        return true;
    }

    /**
     * get the position of x and y based in direction passed by walk
     * and call trywalk to check the possible position
     *
     * @param integer $directionX
     * @param integer $directionY
     *
     * @return boolean
     */
    protected function walkDirection($directionX, $directionY)
    {
        list($x,$y) = $this->getPosition($directionX,$directionY);
        return $this->tryWalk($x, $y);
    }

    /**
     * Based on position passed by walkDirection check if the position is inside of maze
     *
     * @param integer $x
     * @param integer $y
     *
     * @return [integer][integer]
     */
    protected function getPosition($x, $y)
    {
        $positionX = $this->currentPosition[0]+$x;
        $positionY = $this->currentPosition[1]+$y;

        if($positionX < 0 || $positionY < 0)
            return [-1, -1];

        if($positionX >= $this->mazeSize[0] || $positionY >= $this->mazeSize[1])
            return [-1,-1];

        return [$positionX, $positionY];
    }

    /**
     * Try walk checking before if is a wall, a walked path and a valid position
     *
     * @param integer $x
     * @param integer $y
     *
     * @return boolean
     */
    protected function tryWalk($x, $y)
    {
        if($x < 0)
            return false;

        if($this->positionOpen($x, $y) && $this->notLastPosition($x, $y) && !$this->walkedPosition($x, $y))
        {
            $this->newPosition($x, $y);
            return true; 
        }

        return false;
    }

    /**
     * Verify if position is goal or a position that can be walked
     *
     * @return boolean
     */
    protected function positionOpen($x, $y)
    {
        if($this->maze[$x][$y] == 'F')
        {
            $this->Goal = 1;
            return true;
        }
        
        if($this->maze[$x][$y] == 0)
            return true;

        return false;
    }

    /**
     * Verify if position is not last position
     *
     * @return boolean
     */
    protected function notLastPosition($x, $y)
    {
        if($this->lastPosition[0] != $x || $this->lastPosition[1] != $y)
            return true;

        return false;
    }

    /**
     * insert data from currentPosition in lastPosition and path
     * after walk to new position
     */
    protected function newPosition($x, $y)
    {
        $this->path[] = $this->currentPosition;
        $this->lastPosition = $this->currentPosition;
        $this->currentPosition = [$x, $y];
    }
    
    /**
     * Walk back when the current position don't have open "paths"
     *
     * @return boolean
     */
    protected function goBack()
    {
        if(empty($this->path))
        {
            $this->Goal = -1;
            $this->message = "Not found a path to goal";
            return false;
        }
        $this->maze[$this->currentPosition[0]][$this->currentPosition[1]] = 2;
        $this->currentPosition = array_pop($this->path);
        if(empty($this->path))
        {
            $this->lastPosition = [-1,-1];
        }
        else
            $this->lastPosition = $this->path[(count($this->path)-1)];
        return true;
    }

    /**
     * Check if passed position was walked before
     *
     * @param integer $x
     * @param integer $y
     *
     * @return boolean
     */
    protected function walkedPosition($x, $y)
    {
        if(in_array([$x,$y], $this->path))
            return true;

        return false;
    }
}

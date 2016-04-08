<?php

namespace IshyEvandro;

Class Maze
{
    protected $sizex = 0;
    protected $sizey = 0;
    protected $matrix;

    /**
     * set size of the maze
     *
     * @param int $x
     * @param int $y
     *
     * @return boolean
     */
    public function setSize($x, $y)
    {
        if($x === 0 || !is_int($x))
            return false;

        if($y === 0 || !is_int($y))
            return false;

        $this->sizex = $x;
        $this->sizey = $y;
        return true;
    }

    /**
     * Generate a matrix to be used by agent
     *
     * @param string $resource
     *
     * @return boolean
     */
    public function create($resource)
    {
        $resource = str_replace("\n", "", $resource);
        if($this->sizex == 0 || $this->sizey == 0)
            throw new \Exception("Size cant be zero");
        if(strlen($resource) != ($this->sizex * $this->sizey))
            throw new \Exception("Resource size not match with maze size");

        $this->generate($resource);
        return true;
    }

    /**
     * Return the matrix generate
     *
     * @return [$this->sizex][$this->sizey] $this->matrix
     */
    public function get()
    {
        return $this->matrix;
    }

    /**
     * Return dimension of matrix
     *
     * @return [$this->sizex, $this->sizey]
     */
    public function getSize()
    {
        return [$this->sizex, $this->sizey];
    }

    /**
     * Return start position location
     *
     * @return [$x, $start]
     */
    public function getStartPosition()
    {
        $x = 0;
        $start = false;
        while($x < $this->sizex)
        {
            if(($start = array_search("S", $this->matrix[$x]))!== false)
                break;
            $x++;
        }

        if($start === false)
            throw new \Exception("Start position not found");
        return [$x, $start];
    }

    /**
     * Return finish position location
     *
     * @return [$x, $finish]
     */
    public function getFinishPosition()
    {
        $x = 0;
        $finish = false;
        while($x < $this->sizex)
        {
            if(($finish = array_search("F", $this->matrix[$x]))!== false)
                break;
            $x++;
        }

        if($finish === false)
            throw new \Exception("Finish position not found");
        return [$x, $finish];
    }

    /**
     * insert elements from resource in maze
     *
     * @return Boolean
     */
    protected function generate($resource)
    {
        $x = 0;
        while($x < $this->sizex * $this->sizey)
        {
            $arrayElements[] = $resource[$x]; 
            $x++;
        }
        $this->matrix = array_chunk($arrayElements, $this->sizey);
        return true;
    }

}

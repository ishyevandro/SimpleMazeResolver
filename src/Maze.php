<?php

namespace IshyEvandro;

Class Maze
{
    protected $sizex = 0;
    protected $sizey = 0;
    protected $matrix;

    public function setSize($x, $y)
    {
        if($x === 0 || !is_int($x))
            return False;

        if($y === 0 || !is_int($y))
            return False;

        $this->sizex = $x;
        $this->sizey = $y;
        return True;
    }

    public function create($resource)
    {
        $resource = str_replace("\n", "", $resource);
        if($this->sizex == 0 || $this->sizey == 0)
            Throw new \Exception("Size cant be zero");
        if(strlen($resource) != ($this->sizex * $this->sizey))
            Throw new \Exception("Resource size not match with maze size");

        $this->generate($resource);
        return True;
    }

    public function get()
    {
        return $this->matrix;
    }

    public function getSize()
    {
        return [$this->sizex, $this->sizey];
    }

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
            Throw new \Exception("Start position not found");
        return [$x, $start];
    }

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
            Throw new \Exception("Finish position not found");
        return [$x, $finish];
    }

    protected function generate($resource)
    {
        $x = 0;
        while($x < $this->sizex * $this->sizey)
        {
            $arrayElements[] = $resource[$x]; 
            $x++;
        }
        $this->matrix = array_chunk($arrayElements, $this->sizey);
    }

}

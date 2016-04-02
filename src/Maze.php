<?php

namespace IshyEvandro;

Class Maze
{
    protected $size = 0;
    protected $matrix;

    public function setSize($size)
    {
        if($size === 0 || !is_int($size))
            return False;

        $this->size = $size;
        return True;
    }

    public function create($resource)
    {
        $resource = str_replace("\n", "", $resource);
        if($this->size == 0)
            Throw new \Exception("Size cant be zero");
        if(strlen($resource) != ($this->size ** 2))
            Throw new \Exception("Resource size not match with maze size");

        $this->generate($resource);
        return True;
    }

    public function get()
    {
        return $this->matrix;
    }

    protected function generate($resource)
    {
        $x = 0;
        while($x < $this->size ** 2)
        {
            $arrayElements[] = $resource[$x]; 
            $x++;
        }
        $this->matrix = array_chunk($arrayElements, $this->size);
    }
}
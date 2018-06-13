<?php

namespace Logo\Command;

use Logo\Board;
use Logo\CommandInterface;
use Logo\Turtle;

class TurnRight implements CommandInterface
{
    /** @var  int */
    protected $angle;

    public function __construct(int $angle)
    {
        $this->angle = $angle;
    }

    public function run(Turtle $turtle, Board $board)
    {
        $turtle->turn($this->angle);
    }
}
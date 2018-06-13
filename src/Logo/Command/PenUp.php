<?php

namespace Logo\Command;

use Logo\Board;
use Logo\CommandInterface;
use Logo\Turtle;

class PenUp implements CommandInterface
{
    public function run(Turtle $turtle, Board $board)
    {
        $turtle->penUp();
    }
}
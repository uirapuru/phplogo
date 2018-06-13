<?php

namespace Logo\Command;

use Logo\Board;
use Logo\CommandInterface;
use Logo\Turtle;

class Clear implements CommandInterface
{
    public function run(Turtle $turtle, Board $board)
    {
        // @todo reset whole game, move Turtle to center
        $board->clear();
    }
}
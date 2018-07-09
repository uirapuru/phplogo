<?php

namespace Logo\Command;

use Logo\Board;
use Logo\CommandInterface;
use Logo\Turtle;
use Logo\Turtle\Orientation;

class MoveTo implements CommandInterface
{
    /** @var  integer */
    protected $x;

    /** @var  integer */
    protected $y;

    public function __construct(int $x, int $y)
    {
        $this->x = $x;
        $this->y = $y;
    }


    public function run(Turtle $turtle, Board $board)
    {
        $startOrientation = $turtle->orientation();

        $turtle->setOrientation(
            new Orientation($this->x, $this->y, $startOrientation->angle())
        );

    }
}
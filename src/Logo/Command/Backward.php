<?php

namespace Logo\Command;

use Logo\Board;
use Logo\CommandInterface;
use Logo\Turtle;

class Backward implements CommandInterface
{
    /** @var int */
    protected $steps;

    public function __construct(int $steps)
    {
        $this->steps = $steps;
    }

    public function run(Turtle $turtle, Board $board)
    {
        $startOrientation = $turtle->orientation();
        $turtle->walk(-1 * $this->steps);
        $endOrientation = $turtle->orientation();

        if($turtle->pen()->isDown()) {
            $board->drawLine(
                $startOrientation->x(), $startOrientation->y(),
                $endOrientation->x(), $endOrientation->y()
            );
        }
    }
}
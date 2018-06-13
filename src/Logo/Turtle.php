<?php

namespace Logo;

use Logo\Turtle\Orientation;
use Logo\Turtle\Pen;

class Turtle
{
    /** @var string */
    protected $name;

    /** @var  Orientation */
    protected $orientation;

    /** @var  Pen */
    protected $pen;

    public function __construct(string $name, int $x, int $y)
    {
        $this->name = $name;
        $this->pen = new Pen("black", true);
        $this->orientation = new Orientation($x, $y, 0);
    }

    public function walk(int $steps)
    {
        $x = $this->orientation()->x() + $steps * cos($this->orientation()->angle());
        $y = $this->orientation()->y() + $steps * sin($this->orientation()->angle());

        $this->orientation = Orientation::create(
            $x,
            $y,
            $this->orientation()->angle()
        );
    }

    public function turn(int $angle)
    {
        $this->orientation = Orientation::create(
            $this->orientation->x(),
            $this->orientation->y(),
            $angle
        );
    }

    public function orientation() : Orientation
    {
        return $this->orientation;
    }

    public function pen() : Pen
    {
        return $this->pen;
    }
}
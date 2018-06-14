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

    /** @var int */
    protected $distance = 0;

    public function __construct(string $name, int $x, int $y)
    {
        $this->name = $name;
        $this->pen = new Pen("black", true);
        $this->orientation = new Orientation($x, $y, 0);
    }

    public function walk(int $steps) : void
    {
        $x = $this->orientation()->x() + $steps * cos($this->orientation()->radians());
        $y = $this->orientation()->y() + $steps * sin($this->orientation()->radians());

        $this->orientation = Orientation::create(
            $x,
            $y,
            $this->orientation()->angle()
        );

        $this->distance += $steps;
    }

    public function turn(int $angle) : void
    {
        $this->orientation = Orientation::create(
            $this->orientation->x(),
            $this->orientation->y(),
            $this->orientation->angle() + $angle
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

    public function penUp() : void
    {
        $this->pen = Pen::create($this->pen()->color(), false);
    }

    public function penDown() : void
    {
        $this->pen = Pen::create($this->pen()->color(), true);
    }

    public function distance() : int
    {
        return $this->distance;
    }
}
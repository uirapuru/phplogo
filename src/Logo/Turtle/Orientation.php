<?php

namespace Logo\Turtle;

class Orientation
{
    /** @var  integer */
    protected $x;

    /** @var  integer */
    protected $y;

    /** @var  integer */
    protected $angle;

    public function __construct(int $x, int $y, int $angle)
    {
        $this->x = $x;
        $this->y = $y;
        $this->angle = $angle;
    }

    public function x(): int
    {
        return $this->x;
    }

    public function y(): int
    {
        return $this->y;
    }

    public function angle(): int
    {
        return $this->angle;
    }

    public static function create(int $x, int $y, int $angle) : self
    {
        return new self($x, $y, $angle);
    }
}
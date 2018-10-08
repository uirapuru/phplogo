<?php

namespace Logo\Turtle;

class Orientation
{
    /** @var  integer */
    protected $x;

    /** @var  integer */
    protected $y;

    /** @var  string */
    protected $angle;

    public function __construct(int $x, int $y, string $angle)
    {
        $this->x = $x;
        $this->y = $y;
        $this->angle = bcmod($angle, 360);
    }

    public function x(): int
    {
        return $this->x;
    }

    public function y(): int
    {
        return $this->y;
    }

    public function angle(): string
    {
        return $this->angle;
    }

    public static function create(int $x, int $y, string $angle) : self
    {
        return new self($x, $y, $angle);
    }

    public function __toString() : string
    {
        return "[" . $this->x . ", " . $this->y . "] @" . $this->angle;
    }

    public function radians() : float
    {
        return deg2rad($this->angle);
    }
}
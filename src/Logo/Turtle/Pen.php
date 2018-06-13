<?php

namespace Logo\Turtle;

class Pen
{
    /** @var string */
    protected $color;

    /** @var bool */
    protected $isDown = true;

    public function __construct(string $color, bool $isDown)
    {
        $this->color = $color;
        $this->isDown = $isDown;
    }

    public function isDown() : bool
    {
        return $this->isDown === true;
    }

    public function isUp() : bool
    {
        return $this->isDown !== true;
    }

    public static function create(string $color, bool $isDown) : self
    {
        return new self($color, $isDown);
    }
}
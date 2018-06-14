<?php

namespace Logo;

use Logo\Board\Imagine;

class Board
{
    /** @var  int */
    protected $width;

    /** @var  int */
    protected $height;

    /** @var string */
    protected $color;

    /** @var Imagine */
    protected $adapter;

    public function __construct(int $width, int $height, string $color)
    {
        $this->width = $width;
        $this->height = $height;
        $this->color = $color;
        $this->adapter = new Imagine($width, $height, $color);
    }

    public function drawLine(int $fromX, int $fromY, int $toX, int $toY)
    {
        $this->adapter->drawLine($fromX, $fromY, $toX, $toY);
    }

    public function clear() : void
    {

    }
}
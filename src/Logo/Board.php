<?php

namespace Logo;

class Board
{
    /** @var  int */
    protected $width;

    /** @var  int */
    protected $height;

    /** @var string */
    protected $color;

    public function __construct($width, $height, $color)
    {
        $this->width = $width;
        $this->height = $height;
        $this->color = $color;
    }

    public function drawLine(int $fromX, int $fromY, int $toX, int $toY)
    {

    }
}
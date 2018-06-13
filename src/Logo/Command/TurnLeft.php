<?php

namespace Logo\Command;

class TurnLeft
{
    /** @var  int */
    protected $angle;

    public function __construct(int $angle)
    {
        $this->angle = $angle;
    }
}
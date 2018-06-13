<?php

namespace Logo\Command;

class Backward
{
    /** @var int */
    protected $steps;

    public function __construct(int $steps)
    {
        $this->steps = $steps;
    }
}
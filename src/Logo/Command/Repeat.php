<?php

namespace Logo\Command;

class Repeat
{
    /** @var integer */
    protected $count;

    /** @var array */
    protected $commands = [];

    public function __construct(int $count, array $commands)
    {
        $this->count = $count;
        $this->commands = $commands;
    }
}
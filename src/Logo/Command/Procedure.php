<?php

namespace Logo\Command;

class Procedure
{
    /** @var string */
    protected $name;

    /** @var array */
    protected $commands = [];

    public function __construct(string $name, array $commands)
    {
        $this->name = $name;
        $this->commands = $commands;
    }
}
<?php

namespace Logo\Command;

use Logo\Board;
use Logo\CommandInterface;
use Logo\Turtle;

class Procedure implements CommandInterface
{
    /** @var string */
    protected $name;

    /** @var array|CommandInterface[] */
    protected $commands = [];

    public function __construct(string $name, array $commands)
    {
        $this->name = $name;
        $this->commands = $commands;
    }

    public function run(Turtle $turtle, Board $board)
    {
        // TODO: Implement run() method.
    }
}
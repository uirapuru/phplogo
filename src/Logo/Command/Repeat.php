<?php

namespace Logo\Command;

use Logo\Board;
use Logo\CommandInterface;
use Logo\Turtle;

class Repeat implements CommandInterface
{
    /** @var integer */
    protected $count;

    /** @var array|CommandInterface[] */
    protected $commands = [];

    public function __construct(int $count, array $commands)
    {
        $this->count = $count;
        $this->commands = $commands;
    }

    public function run(Turtle $turtle, Board $board)
    {
        for($i = 0; $i < $this->count; $i++) {
            foreach($this->commands as $command) {
                $command->run($turtle, $board);
            }
        }
    }
}
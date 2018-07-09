<?php

namespace Logo\Command;

use Logo\Board;
use Logo\CommandInterface;
use Logo\Program;
use Logo\Turtle;

class DefineFunction implements CommandInterface
{
    /** @var string */
    protected $name;

    /** @var array */
    protected $listing;

    /** @var array */
    protected $arguments;

    public function __construct(string $name, array $listing, array $arguments)
    {
        $this->name = $name;
        $this->listing = $listing;
        $this->arguments = $arguments;
    }

    public function run(Turtle $turtle, Board $board)
    {
        Program::addFunction(new FunctionClass($this->name, $this->listing, $this->arguments));
    }
}
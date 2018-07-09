<?php

namespace Logo;

class Game
{
    /** @var Board */
    protected $board;

    /** @var  Turtle */
    protected $turtle;

    /** @var array|CommandInterface[] */
    protected $commands = [];

    public function __construct(int $width = 320, int $height = 240)
    {
        $this->board = new Board($width, $height, '#ffffff');
        $this->turtle = new Turtle('stefan', $width/2, $height/2);
    }

    public function addCommand(CommandInterface $command) : void
    {
        $this->commands[] = $command;
    }

    public function run()
    {
        foreach($this->commands as $command) {
            $command->run($this->turtle, $this->board);
        }
    }

    public function getBoard(): Board
    {
        return $this->board;
    }

    public function getTurtle(): Turtle
    {
        return $this->turtle;
    }

    public function addCommands(array $commands)
    {
        foreach ($commands as $command) {
            $this->commands[] = $command;
        }
    }
}
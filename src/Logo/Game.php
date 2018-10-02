<?php

namespace Logo;

use Imagine\Image\Box;
use Imagine\Image\ImageInterface;
use Imagine\Image\Point;

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

    public function board(): Board
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

    public function image() : ImageInterface
    {
        $width = 64;
        $height = 40;

        $orientation = $this->turtle->orientation();

        return $this->board->image()->paste(
            $this->turtle->image()->resize(new Box($width, $height)),
            new Point($orientation->x() - $width/2, $orientation->y() - $height/2)
        );
    }
}
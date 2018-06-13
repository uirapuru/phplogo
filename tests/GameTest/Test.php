<?php

namespace GameTest;

use GameTest;
use Logo\Command\Forward;
use Logo\Command\TurnRight;
use Logo\Game;
use PHPUnit\Framework\TestCase;

class Test extends TestCase
{
    public function testCreation()
    {
        $game = new Game();

        $game->addCommands([
            new TurnRight(65),
            new Forward(30),
        ]);

        $game->run();

        $turtle = $game->getTurtle();

        die(var_dump($turtle->orientation()));
    }
}

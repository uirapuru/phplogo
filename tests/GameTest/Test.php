<?php

namespace GameTest;

use GameTest;
use Logo\Command\Forward;
use Logo\Command\Repeat;
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

        $this->assertEquals(172, $turtle->orientation()->x(), "Turtle is at: " . $turtle->orientation());
        $this->assertEquals(147, $turtle->orientation()->y(), "Turtle is at: " . $turtle->orientation());
        $this->assertEquals(65, $turtle->orientation()->angle(), "Turtle is at: " . $turtle->orientation());
        $this->assertTrue($turtle->pen()->isDown());
        $this->assertEquals(30, $turtle->distance());
    }

}

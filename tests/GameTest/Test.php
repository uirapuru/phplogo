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

        $this->assertEquals(143, $turtle->orientation()->x());
        $this->assertEquals(144, $turtle->orientation()->y());
        $this->assertEquals(65, $turtle->orientation()->angle());
        $this->assertTrue($turtle->pen()->isDown());
    }
}

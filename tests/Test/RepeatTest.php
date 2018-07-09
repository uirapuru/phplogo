<?php
namespace Test;

use Logo\Board;
use Logo\Command\Forward;
use Logo\Command\Repeat;
use Logo\Command\TurnRight;
use Logo\CommandInterface;
use Logo\Game;
use Logo\Turtle;
use PHPUnit\Framework\TestCase;

class RepeatTest extends TestCase
{

    public function testRun()
    {
        $turtle = new Turtle("stefan", 0, 0);
        $board = new Board(320, 200, "#000000");

        $mock1 = $this->prophesize(CommandInterface::class);
        $mock1->run($turtle, $board)->shouldBeCalledTimes(3);

        $mock2 = $this->prophesize(CommandInterface::class);
        $mock2->run($turtle, $board)->shouldBeCalledTimes(3);

        $mock3 = $this->prophesize(CommandInterface::class);
        $mock3->run($turtle, $board)->shouldBeCalledTimes(3);

        $command = new Repeat(3, [$mock1->reveal(), $mock2->reveal(), $mock3->reveal()]);

        $command->run($turtle, $board);
    }

    public function testCommand()
    {
        $game = new Game();

        $turtle = $game->getTurtle();

        $this->assertEquals(160, $turtle->orientation()->x(), "Turtle is at: " . $turtle->orientation());
        $this->assertEquals(120, $turtle->orientation()->y(), "Turtle is at: " . $turtle->orientation());
        $this->assertEquals(0, $turtle->orientation()->angle(), "Turtle is at: " . $turtle->orientation());
        $this->assertTrue($turtle->pen()->isDown());
        $this->assertEquals(0, $turtle->distance());

        $game->addCommand(new Repeat(4, [
            new Forward(30),
            new TurnRight(90),
        ]));

        $game->run();

        $turtle = $game->getTurtle();

        $this->assertEquals(160, $turtle->orientation()->x(), "Turtle is at: " . $turtle->orientation());
        $this->assertEquals(120, $turtle->orientation()->y(), "Turtle is at: " . $turtle->orientation());
        $this->assertEquals(0, $turtle->orientation()->angle(), "Turtle is at: " . $turtle->orientation());
        $this->assertTrue($turtle->pen()->isDown());
        $this->assertEquals(120, $turtle->distance());
    }
}

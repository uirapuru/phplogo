<?php

namespace Test\ParserTest;

use Logo\Command\Forward;
use Logo\Command\MoveTo;
use Logo\Command\PenDown;
use Logo\Command\PenUp;
use Logo\Command\Repeat;
use Logo\Command\TurnRight;
use Logo\Game;
use Parser\Parser;
use PHPUnit\Framework\TestCase;

class ParserTest extends TestCase
{
    public function testOneLiner()
    {
        $result = Parser::fromString("penDown");
        $this->assertInstanceOf(PenDown::class, $result[0]);
    }

    public function testOneLinerWithArgument()
    {
        /** @var Forward $result */
        $result = Parser::fromString("forward 30");
        $this->assertInstanceOf(Forward::class, $result[0]);
        $this->assertEquals(30, array_values((array) $result[0])[0]);
    }

    public function testMulticommandsInLine()
    {
        /** @var Forward $result */
        $result = Parser::fromString("forward 30 turnRight 20 penUp penDown");

        $this->assertInstanceOf(Forward::class, $result[0]);
        $this->assertInstanceOf(TurnRight::class, $result[1]);
        $this->assertInstanceOf(PenUp::class, $result[2]);
        $this->assertInstanceOf(PenDown::class, $result[3]);
    }

    public function testMultiline()
    {
        $userInput = <<<EOL
forward 30 
turnRight 90
forward 15
turnRight 30
EOL;
        $result = Parser::fromString($userInput);

        $this->assertCount(4, $result);
        $this->assertInstanceOf(Forward::class, $result[0]);
        $this->assertInstanceOf(TurnRight::class, $result[1]);
        $this->assertInstanceOf(Forward::class, $result[2]);
        $this->assertInstanceOf(TurnRight::class, $result[3]);

    }

    public function testRepeat()
    {
        $userInput = "repeat 4 [ forward 20 turnRight 20 ]";

        $result = Parser::fromString($userInput);

        $this->assertInstanceOf(Repeat::class, $result[0]);
        $this->assertEquals(4, array_values((array) $result[0])[0]);

        $innerCommandsArray = array_values((array) $result[0])[1];
        $this->assertCount(2, $innerCommandsArray);
        $this->assertInstanceOf(Forward::class, $innerCommandsArray[0]);
        $this->assertInstanceOf(TurnRight::class, $innerCommandsArray[1]);
    }

    public function testComplexList()
    {
        $userInput = <<<EOL
forward 30 
turnRight 90
forward 15
turnRight 30

repeat 4 [ forward 20 turnRight 20 ]

penUp
EOL;
        $game = new Game();
        $game->addCommands(Parser::fromString($userInput));
        $game->run();

        $turtle = $game->getTurtle();

        $this->assertEquals(125, $turtle->orientation()->x(), "Turtle is at: " . $turtle->orientation());
        $this->assertEquals(170, $turtle->orientation()->y(), "Turtle is at: " . $turtle->orientation());
        $this->assertEquals(200, $turtle->orientation()->angle(), "Turtle is at: " . $turtle->orientation());
        $this->assertTrue($turtle->pen()->isUp());
        $this->assertEquals(125, $turtle->distance());

    }

    public function testPentagon()
    {
        $userInput = "repeat 5 [ forward 150 turnRight 144 ]";

        $game = new Game();
        $game->addCommand(new MoveTo(160,120));
        $game->addCommands(Parser::fromString($userInput));
        $game->run();

        $turtle = $game->getTurtle();
        $this->assertTrue($turtle->pen()->isDown());
    }
}

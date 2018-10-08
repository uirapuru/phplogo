<?php

namespace Test\ParserTest;

use Logo\Command\Forward;
use Logo\Command\MoveTo;
use Logo\Command\PenDown;
use Logo\Command\PenUp;
use Logo\Command\Repeat;
use Logo\Command\TurnRight;
use Logo\Game;
use Logo\Program;
use Parser\DateExpressionLexer;
use Parser\Parser;
use Parser\Variable;
use Parser\Variable\VariableInterface;
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

    public function testNestedRepeat()
    {
        $userInput = "repeat 4 [ repeat 4 [ forward 10 turnLeft 20 ] forward 20 turnRight 20 ]";

        $result = Parser::fromString($userInput);

        $this->assertInstanceOf(Repeat::class, $result[0]);
        $this->assertEquals(4, array_values((array) $result[0])[0]);

        $innerCommandsArray = array_values((array) $result[0])[1];
        $this->assertCount(3, $innerCommandsArray);
        $this->assertInstanceOf(Repeat::class, $innerCommandsArray[0]);
        $this->assertInstanceOf(Forward::class, $innerCommandsArray[1]);
        $this->assertInstanceOf(TurnRight::class, $innerCommandsArray[2]);
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

    public function testFloat()
    {
        $userInput = <<<EOL
turnRight 36.6
forward 200 
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

    public function testAssignString()
    {
        $userInput = <<<EOL
:e1 = "some text"
:e2 = "abcdefghijklmno prstuqrwxyzABCDEFG HIJKLMNOPRQSTUWXYZ123456677890-=\!@#$%^&*()_+|ĄĘŹĆŁÓŻŹżźŹ"
:e3 = 'some text'
:e4 = 'abcdefghijklmnopr stuqrwxyzABCDEFGHI JKLMNOPRQSTUWXYZ123456677890-=\!@#$%^&*()_+|ĄĘŹĆŁÓŻŹżźŹ'
:e5 = 'lastValue'
:jakasInnaZmienna = 'hello world();'
EOL;
        Parser::fromString($userInput);

        $this->assertEquals("some text", Program::getVariable("e1")->val());
        $this->assertEquals("abcdefghijklmno prstuqrwxyzABCDEFG HIJKLMNOPRQSTUWXYZ123456677890-=\!@#$%^&*()_+|ĄĘŹĆŁÓŻŹżźŹ", Program::getVariable("e2")->val());

        $this->assertEquals("lastValue", Program::getVariable('e5')->val());
        $this->assertEquals("hello world();", Program::getVariable('jakasInnaZmienna')->val());
    }

    public function testAssignInt()
    {
        $userInput = ':e = 1410';

        Parser::fromString($userInput);

        $this->assertEquals(1410, Program::getVariable("e")->val());
    }

    public function testDefineVariable()
    {
        $userInput = <<<EOL
:xyz = 150
:abc = "some text"
EOL;
        /** @var VariableInterface[] $result */
        $result = Parser::fromString($userInput);

        $this->assertEquals(150, Program::getVariable("xyz")->val());
        $this->assertEquals("some text", Program::getVariable("abc")->val());
    }

    public function testReadVariable()
    {
        Program::addVariable(Variable::int("xyz", 150));

        $userInput = <<<EOL
forward :xyz
EOL;
        /** @var VariableInterface[] $result */
        $result = Parser::fromString($userInput);
        $forward = array_pop($result);
        $this->assertEquals($forward, new Forward(150));
    }

    public function testDefineFunction()
    {
        $this->markTestIncomplete("function definition not yet supported");

        $userInput = <<<EOL
to square :a
    repeat 4 [ forward :a turnRight 90 ]   
end
EOL;
        $result = Parser::fromString($userInput);

        die(var_dump($result));

        $this->assertEquals(150, $result[0]->value());
        $this->assertEquals("some text", $result[1]->value());
    }

    public function testPentagram()
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

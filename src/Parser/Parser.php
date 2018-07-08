<?php

namespace Parser;

use Logo\Command\Backward;
use Logo\Command\Clear;
use Logo\Command\Forward;
use Logo\Command\PenDown;
use Logo\Command\PenUp;
use Logo\Command\Repeat;
use Logo\Command\TurnLeft;
use Logo\Command\TurnRight;

class Parser
{
    static $_FUNCTIONS_WITH_ARGS = [
        "forward" => Forward::class,
        "backward" => Backward::class,
        "turnLeft" => TurnLeft::class,
        "turnRight" => TurnRight::class,
    ];

    static $_FUNCTIONS = [
        "penDown" => PenDown::class,
        "penUp" => PenUp::class,
        "repeat" => Repeat::class,
        "clear" => Clear::class
    ];

    public static function fromString(string $string)
    {
        $lexer = new DateExpressionLexer();
        $stream = $lexer->lex($string);

        $gramma = new DateExpressionGrammar();
        $parser = new DateExpressionParser($gramma);

        return $parser->parse($stream);
    }
}
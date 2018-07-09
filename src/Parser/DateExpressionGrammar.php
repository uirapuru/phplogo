<?php

namespace Parser;

use Dissect\Lexer\CommonToken;
use Dissect\Parser\Grammar;
use function func_get_args;
use Logo\Command\Backward;
use Logo\Command\Clear;
use Logo\Command\Forward;
use Logo\Command\PenDown;
use Logo\Command\PenUp;
use Logo\Command\Repeat;
use Logo\Command\TurnLeft;
use Logo\Command\TurnRight;
use Logo\Program;
use Parser\Variable\IntVariable;
use Parser\Variable\StringVariable;

class DateExpressionGrammar extends Grammar
{
    public function __construct()
    {;

        $this('Program')
            ->is('Program','Command')
            ->call(function ($list, $foo) {
                $list[] = $foo;

                return $list;
            })
            ->is('Command')
            ->call(function ($command) {
                return [$command];
            })
        ;

        $this('Command')
            ->is('forward', 'int')
            ->call(function (CommonToken $command, CommonToken $value) {
                return new Forward($value->getValue());
            })
            ->is('backward', 'int')
            ->call(function (CommonToken $command, CommonToken $value) {
                return new Backward($value->getValue());
            })
            ->is('turnLeft', 'int')
            ->call(function (CommonToken $command, CommonToken $value) {
                return new TurnLeft($value->getValue());
            })
            ->is('turnRight', 'int')
            ->call(function (CommonToken $command, CommonToken $value) {
                return new TurnRight($value->getValue());
            })
            ->is('penDown')
            ->call(function () {
                return new PenDown();
            })
            ->is('penUp')
            ->call(function () {
                return new PenUp();
            })
            ->is('clear')
            ->call(function () {
                return new Clear();
            })
            ->is('"', 'string', '"')
            ->call(function (CommonToken $string) : string {
                return trim($string->getValue(), '"');
            })
//            ->is('string')
//            ->call(function (CommonToken $string) : string {
//                return trim($string->getValue(), '"');
//            })
            ->is('int')
            ->call(function (CommonToken $int) : int {
                return $int->getValue();
            })
            ->is('repeat', "int", "Block")
            ->call(function (CommonToken $name, CommonToken $number, array $commands) {
                return new Repeat((int) $number->getValue(), $commands);
            })
            ->is('variable', "=", "int")
            ->call(function (CommonToken $variable, $_, CommonToken $integer) : IntVariable {
                $var = new IntVariable($variable->getValue(), $integer->getValue());
                Program::addVariable($var);
                return $var;
            })
            ->is('variable', "=", "string")
            ->call(function (CommonToken $variable, $_, CommonToken $string) : StringVariable {
                $var = new StringVariable($variable->getValue(), trim($string->getValue(),'"'));
                Program::addVariable($var);
                return $var;
            })
        ;

        $this('Block')
            ->is('[', 'Program', ']')
            ->call(function ($o, $commands, $b) : array {
                return $commands;
            });

//        $this('String')
//            ->is('""', 'String', '""')
//            ->call(function ($o, $commands, $b) : array {
//                return $commands;
//            });

        $this->start('Program');
    }
}
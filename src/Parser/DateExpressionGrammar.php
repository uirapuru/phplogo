<?php

namespace Parser;

use Dissect\Lexer\CommonToken;
use Dissect\Parser\Grammar;
use Logo\Command\Backward;
use Logo\Command\Clear;
use Logo\Command\Forward;
use Logo\Command\PenDown;
use Logo\Command\PenUp;
use Logo\Command\Repeat;
use Logo\Command\TurnLeft;
use Logo\Command\TurnRight;
use Logo\Program;

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
            ->is('repeat', "int", "Block")
            ->call(function (CommonToken $name, CommonToken $number, array $commands) {
                return new Repeat((int) $number->getValue(), $commands);
            })
        ;

        $this('Block')
            ->is('[', 'Program', ']')
            ->call(function ($o, $commands, $b) : array {
                return $commands;
            });

        $this->start('Program');
    }
}
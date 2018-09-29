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
            ->is('Program','Instruction')
            ->call(function ($list, $foo) {
                $list[] = $foo;

                return $list;
            })
            ->is('Instruction')
            ->call(function ($foo) {
                return [$foo];
            })
        ;

        $this("Instruction")
            ->is('ProcedureCall')
            ->is('Assignment')
        ;

        $this("ProcedureCall")
            ->is('Procedure', 'variable')
            ->call(function () {
                die(var_dump(func_get_args()));
            })
            ->is('Procedure', 'int')
            ->is('Procedure', 'string')
            ->is('Procedure')
        ;

        $this('Procedure')
            ->is('forward', 'Argument')
            ->call(function (CommonToken $command, CommonToken $value) {
                if($value->getType() === "variable") {
                    $var = $this->getVariable($value->getValue());
                } else {
                    $var = $value->getValue();
                }

                return new Forward($var);
            })
            ->is('backward', 'Argument')
            ->call(function (CommonToken $command, CommonToken $value) {
                return new Backward($value->getValue());
            })
            ->is('turnLeft', 'Argument')
            ->call(function (CommonToken $command, CommonToken $value) {
                return new TurnLeft($value->getValue());
            })
            ->is('turnRight', 'Argument')
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
            ->is('repeat', "Argument", "Block")
            ->call(function (CommonToken $name, CommonToken $number, array $commands) {
                return new Repeat((int) $number->getValue(), $commands);
            })
        ;

        $this('Argument')
            ->is("int")
            ->is("string")
            ->is("variable")
        ;

        $this('Assignment')
            ->is('variable', "=", "int")
            ->call(function (CommonToken $variable, $_, CommonToken $integer) : IntVariable {
                $var = new IntVariable($variable->getValue(), $integer->getValue());
                Program::addVariable($var);
                return $var;
            })
            ->is('variable', "=", "string")
            ->call(function (CommonToken $variable, $_, CommonToken $string) : StringVariable {
                $var = new StringVariable(ltrim($variable->getValue(), ":"), trim($string->getValue(),'"\''));
                Program::addVariable($var);
                return $var;
            })
        ;

        $this('String')
            ->is('"', 'String', '"')
            ->call(function ($l, string $string, $r) : string {
                return $string;
            })
            ->is("'", 'String', "'")
            ->call(function () : string {
                die(var_dump(func_get_args()));
            })
            ->is('string')
            ->call(function (CommonToken $string) : string {
                return $string->getValue();
            })
        ;

        $this('Block')
            ->is('[', 'Program', ']')
            ->call(function ($o, $commands, $b) : array {
                return $commands;
            })
        ;

        $this->start('Program');
    }

    private function getVariable(string $variableName)
    {
        return Program::getVariable($variableName);
    }
}
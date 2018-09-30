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
use Logo\CommandInterface;
use Logo\Program;
use Parser\Variable\IntVariable;
use Parser\Variable\StringVariable;
use Ramsey\Uuid\Uuid;

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
            ->is('Procedure')
            ->is('Assignment')
            ->is('FunctionDefinition')
        ;

        $this('Procedure')
            ->is('command')
            ->call(function (CommonToken $command) : CommandInterface {
                return CommandFactory::get($command->getValue());
            })
            ->is('command', 'ListOfArguments')
            ->call(function (CommonToken $command, array $arguments) : CommandInterface {
                return CommandFactory::get($command->getValue(), $arguments);
            })
            ->is('command', 'ListOfArguments',  'Block')
            ->call(function (CommonToken $command, array $arguments, array $commands) : CommandInterface {
                return CommandFactory::get($command->getValue(), [$arguments[0], $commands]);
            })
        ;

        $this("ListOfArguments")
            ->is('ListOfArguments', 'Argument')
            ->call(function (array $list, $argument) {
                $list[] = $argument;
                return $list;
            })
            ->is('Argument')
            ->call(function (Variable $argument) {
                return [$argument->val()];
            })
        ;

        $this('Argument')
            ->is("int")
            ->call(function (CommonToken $token) : Variable {
                return Variable::int(null, ltrim($token->getValue()));
            })
            ->is("string")
            ->call(function (CommonToken $token) : Variable {
                return Variable::string(null, trim($token->getValue(), "\"\'"));
            })
            ->is("variable")
            ->call(function (CommonToken $token) : Variable {
                return $this->getVariable(ltrim($token->getValue(), ":"));
            })
        ;

        $this('Assignment')
            ->is('variable', "=", "Argument")
            ->call(function (CommonToken $variable, $_, Variable $argument) {
                Program::addVariable($argument->copyAs($variable->getValue()));
            })
        ;

        // defining function

//        $this('FunctionDefinition')
//            ->is('to', "etiquette", "Program", "end")
//            ->call(function () {
//                die(var_dump(func_get_args()));
//            })
//            ->is('to', "etiquette", "FunctionArgumentList", "Program", "end")
//            ->call(function () {
//                die(var_dump(func_get_args()));
//            })
//        ;
//
//        $this("FunctionArgumentList")
//            ->is('FunctionArgumentList', 'FunctionArgument')
//            ->call(function (array $list, $argument) {
//                $list[] = $argument;
//                return $list;
//            })
//            ->is('FunctionArgument')
//            ->call(function ($argument) {
//                return [$argument];
//            })
//        ;
//
//        $this("FunctionArgument")
//            ->is("argument")
//            ->call(function (CommonToken $token) : string {
//                return ltrim($token->getValue(), ":");
//            })
//        ;

        // blocks

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
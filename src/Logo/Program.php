<?php

namespace Logo;

use Logo\Program\FunctionClass;
use Parser\Variable\VariableInterface;

class Program
{
    static private $FUNCTIONS = [];
    static private $VARIABLES = [];

    public static function addFunction(FunctionClass $function)
    {
        self::$FUNCTIONS[] = $function;
    }

    public static function addVariable(VariableInterface $variable)
    {
        self::$VARIABLES[$variable->name()] = $variable;
    }
}
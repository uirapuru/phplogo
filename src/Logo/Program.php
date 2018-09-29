<?php

namespace Logo;

use Logo\Program\FunctionClass;
use Parser\Variable;
use Parser\Variable\VariableInterface;

class Program
{
    static private $FUNCTIONS = [];

    /** @var array|Variable[] */
    static private $VARIABLES = [];

    public static function addFunction(FunctionClass $function)
    {
        self::$FUNCTIONS[] = $function;
    }

    public static function addVariable(VariableInterface $variable)
    {
        self::$VARIABLES[$variable->name()] = $variable;
    }

    public static function getVariable(string $name) : VariableInterface
    {
        if(!array_key_exists($name, self::$VARIABLES))
        {
            throw new \Exception("Variable " . $name . " is not set!");
        }

        return self::$VARIABLES[$name];
    }
}
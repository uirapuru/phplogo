<?php

namespace Logo;

use Logo\Program\FunctionClass;
use Parser\Variable;
use Parser\Variable\VariableInterface;
use Webmozart\Assert\Assert;

class Program
{
    static private $FUNCTIONS = [];

    /** @var array|Variable[] */
    static private $VARIABLES = [];

    public static function addFunction(FunctionClass $function)
    {
        self::$FUNCTIONS[] = $function;
    }

    public static function addVariable(Variable $variable)
    {
        self::$VARIABLES[$variable->name()] = $variable;
    }

    public static function getVariable(string $name) : Variable
    {
        Assert::keyExists(self::$VARIABLES, $name,"Variable " . $name . " is not set!");

        return self::$VARIABLES[$name];
    }
}
<?php

namespace Parser;

use Dissect\Lexer\CommonToken;
use Logo\Command\Backward;
use Logo\Command\Clear;
use Logo\Command\Forward;
use Logo\Command\PenDown;
use Logo\Command\PenUp;
use Logo\Command\Repeat;
use Logo\Command\TurnLeft;
use Logo\Command\TurnRight;
use Logo\CommandInterface;
use Webmozart\Assert\Assert;

class CommandFactory
{
    private static $commands = [
        'backward'  => Backward::class,
        'clear'     => Clear::class,
        'forward'   => Forward::class,
        'turnLeft'  => TurnLeft::class,
        'turnRight' => TurnRight::class,
        'penDown'   => PenDown::class,
        'penUp'     => PenUp::class,
        'repeat'    => Repeat::class,
    ];

    public static function get(string $commandName, array $arguments = []) : CommandInterface
    {
        Assert::keyExists(self::$commands, $commandName, "Command " . $commandName . " not registered");

        $class = self::$commands[$commandName];

        $arguments = array_map(function ($argument) {
            if ($argument instanceof CommonToken) {
                return $argument->getValue();
            }

            return $argument;
        }, $arguments);

        return new $class(...$arguments);
    }
}
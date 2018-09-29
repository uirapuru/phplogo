<?php

namespace Parser;

class Variable
{
    /** @var string */
    protected $name;

    /** @var int */
    protected $intValue;

    /** @var string */
    protected $stringValue;

    protected function __construct(string $name, int $intValue = null, string $stringValue = null)
    {
        $this->name = $name;
        $this->intValue = $intValue;
        $this->stringValue = $stringValue;
    }

    public static function string(string $name, string $value) : self
    {
        return new self($name, null, $value);
    }

    public static function int(string $name, int $value) : self
    {
        return new self($name, $value);
    }
}
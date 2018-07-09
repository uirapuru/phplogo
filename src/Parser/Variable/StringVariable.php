<?php

namespace Parser\Variable;

class StringVariable implements VariableInterface
{
    /** @var string */
    protected $name;

    /** @var string */
    protected $value;

    public function __construct(string $name, string $value)
    {
        $this->name = $name;
        $this->value = $value;
    }

    public function __toString() : string
    {
        return $this->value;
    }

    public function value(): string
    {
        return $this->value;
    }

    public function name(): string
    {
        return $this->name;
    }
}
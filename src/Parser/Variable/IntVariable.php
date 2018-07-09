<?php

namespace Parser\Variable;

class IntVariable implements VariableInterface
{
    /** @var string */
    protected $name;

    /** @var integer */
    protected $value;

    public function __construct(string $name, int $value)
    {
        $this->name = $name;
        $this->value = $value;
    }

    public function value(): int
    {
        return $this->value;
    }

    public function name(): string
    {
        return $this->name;
    }
}
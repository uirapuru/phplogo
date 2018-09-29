<?php

namespace Parser;

use Ramsey\Uuid\Uuid;
use Webmozart\Assert\Assert;

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
        $name = ltrim($name, ":");
        Assert::regex($name, "@^([a-zA-Z0-9\-]+)$@");

        $this->name = $name;
        $this->intValue = $intValue;
        $this->stringValue = $stringValue;
    }

    public static function string(?string $name, string $value) : self
    {
        return new self($name ?? Uuid::uuid4(), null, $value);
    }

    public static function int(?string $name, int $value) : self
    {
        return new self($name ?? Uuid::uuid4(), $value);
    }

    public function name() : string
    {
        return ltrim($this->name, ":");
    }

    public function val()
    {
        return $this->intValue ?? $this->stringValue;
    }

    public function copyAs(?string $newName) : self
    {
        return new self($newName, $this->intValue, $this->stringValue);
    }
}
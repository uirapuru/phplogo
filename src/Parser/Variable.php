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

    /** @var float */
    protected $floatValue;

    protected function __construct(string $name, int $intValue = null, string $stringValue = null, float $floatValue = null)
    {
        $name = ltrim($name, ":");
        Assert::regex($name, "@^([a-zA-Z0-9\-]+)$@");

        $this->name = $name;
        $this->intValue = $intValue;
        $this->stringValue = $stringValue;
        $this->floatValue = $floatValue;
    }

    public static function string(?string $name, string $value) : self
    {
        return new self($name ?? Uuid::uuid4(), null, $value);
    }

    public static function int(?string $name, int $value) : self
    {
        return new self($name ?? Uuid::uuid4(), $value);
    }

    public static function float(?string $name, string $value) : self
    {
        return new self($name ?? Uuid::uuid4(), null, null, floatval($value));
    }

    public function name() : string
    {
        return ltrim($this->name, ":");
    }

    public function val()
    {
        return $this->intValue ?? $this->stringValue ?? $this->floatValue;
    }

    public function copyAs(?string $newName) : self
    {
        return new self($newName, $this->intValue, $this->stringValue);
    }
}
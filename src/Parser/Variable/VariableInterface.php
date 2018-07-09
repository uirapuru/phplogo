<?php
namespace Parser\Variable;

interface VariableInterface
{

    public function value();

    public function name(): string;
}
<?php

namespace Parser;

use Symfony\Component\ExpressionLanguage\Compiler;
use Symfony\Component\ExpressionLanguage\ExpressionFunction;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage as BaseExpressionLanguage;

class ExpressionLanguage extends BaseExpressionLanguage
{
    private $cache;
    private $lexer;
    private $parser;
    private $compiler;

    protected function registerFunctions()
    {
        $this->addFunction(ExpressionFunction::fromPhp('constant'));
    }

    private function getLexer(): Lexer
    {
        if (null === $this->lexer) {
            $this->lexer = new Lexer();
        }

        return $this->lexer;
    }

    private function getParser(): Parser
    {
        if (null === $this->parser) {
            $this->parser = new Parser($this->functions);
        }

        return $this->parser;
    }

    private function getCompiler(): Compiler
    {
        if (null === $this->compiler) {
            $this->compiler = new Compiler($this->functions);
        }

        return $this->compiler->reset();
    }
}
<?php

namespace Parser;

class Parser
{
    public static function fromString(string $string)
    {
        $lexer = new DateExpressionLexer();
        $stream = $lexer->lex($string);

        $gramma = new DateExpressionGrammar();
        $parser = new DateExpressionParser($gramma);

        return $parser->parse($stream);
    }
}
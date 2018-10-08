<?php

namespace Parser;

class Parser
{
    protected static $cache;

    public static function fromString(string $string)
    {
        $md5 = hash("md5", $string);

        if(!isset($cache[$md5])) {
            $lexer = new DateExpressionLexer();
            $stream = $lexer->lex($string);

            $gramma = new Grammar();
            $parser = new DateExpressionParser($gramma);

            self::$cache[$md5] = $parser->parse($stream);
        }

        return self::$cache[$md5];
    }
}
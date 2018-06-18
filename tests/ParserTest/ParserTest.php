<?php

namespace Test\ParserTest;

use PHPUnit\Framework\TestCase;
use Parser\ExpressionLanguage;

class ParserTest extends TestCase
{
    public function testParser()
    {
        $userInput = <<<EOL
naprzód 30
prawo 90
wstecz 15
podnieś
opuść
naprzód 30

powtórz 4 [ naprzód 40 prawo 90 ]

wyczyść
EOL;

        $expressionLanguage = new ExpressionLanguage();

//        $expressionLanguage->register('naprzód', function ($str) {
//            return sprintf('(is_string(%1$s) ? strtolower(%1$s) : %1$s)', $str);
//        }, function ($arguments, $str) {
//            return new Forward($str);
//        });
//
//        $expressionLanguage->register('wstecz', function ($str) {
//            return sprintf('(is_string(%1$s) ? strtolower(%1$s) : %1$s)', $str);
//        }, function ($arguments, $str) {
//            return new Backward($str);
//        });

        var_dump($expressionLanguage->evaluate($userInput));
    }
}

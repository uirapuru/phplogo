<?php

namespace Test\ParserTest;

use PHPUnit\Framework\TestCase;
use Parser\ExpressionLanguage;
use Symfony\Component\Yaml\Yaml;

class ParserTest extends TestCase
{
    public function testParser()
    {
        $commands = [];
        $cursor = 0;

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
        $lines = explode(PHP_EOL, $userInput);
        $config = Yaml::parse(file_get_contents(realpath(__DIR__ . "/../../src/Parser/Resources/config/commands.pl.yml")));
        $class = null;

        $result = array_filter($lines, function(string $line, string $key) use ($config, $class) : bool {
            foreach($config as $configString) {
                $result = sscanf($line, $configString);
                if($result[0] !== null) {
                    return $result[0];
                } else {
                    continue;
                }
            }

            return false;
        }, ARRAY_FILTER_USE_BOTH);


        die(var_dump($result, $class));


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

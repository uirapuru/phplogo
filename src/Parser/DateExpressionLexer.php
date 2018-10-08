<?php

namespace Parser;

use Dissect\Lexer\SimpleLexer;

class DateExpressionLexer extends SimpleLexer
{
    public function __construct()
    {
        $commands = implode("|", array_keys(CommandFactory::$commands));

        $this->regex('command', "@(" . $commands . ")@");

//        $this->token("to");
//        $this->regex('etiquette', '@([a-z\_]+)@u');
//        $this->regex('argument', '@(_[^\W]+)@u');
//        $this->token("end");

        $this->token("[");
        $this->token("]");
        $this->token("=");

        $this->regex('variable', '@(:[^\W]+)@u');

        $this->regex('int', '@^(\d+)@');
        $this->regex('float', '@^(\d+)\.(\d+)@');
        $this->regex('string', '@^([\'"][^\"\'\n\r\t]+[\'""])@');

        $this->regex('WSP', "/^[ \r\n\t]+/");
        $this->regex('CMT', '|^//.*|');

        $this->skip('WSP');
    }
}
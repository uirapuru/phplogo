<?php

namespace Parser;

use Dissect\Lexer\SimpleLexer;

class DateExpressionLexer extends SimpleLexer
{
    public function __construct()
    {
//        $this->token("forward");
//        $this->token("backward");
//        $this->token("turnLeft");
//        $this->token("turnRight");
//        $this->token("penDown");
//        $this->token("penUp");
//        $this->token("repeat");
//        $this->token("clear");

        $this->regex('command', "@(forward|backward|turnLeft|turnRight|penDown|penUp|repeat|clear)@");

        $this->token("to");
        $this->token("end");

        $this->token("[");
        $this->token("]");
        $this->token("=");

        $this->regex('variable', '@(:[^\W]+)@u');

        $this->regex('int', '@^(\d+)@');
        $this->regex('string', '@^([\'"][^\"\'\n\r\t]+[\'""])@');

        $this->regex('WSP', "/^[ \r\n\t]+/");
        $this->regex('CMT', '|^//.*|');

        $this->skip('WSP');
    }
}
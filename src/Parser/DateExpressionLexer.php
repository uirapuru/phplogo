<?php

namespace Parser;

use Dissect\Lexer\SimpleLexer;

class DateExpressionLexer extends SimpleLexer
{
    public function __construct()
    {
        $this->token("forward");
        $this->token("backward");
        $this->token("turnLeft");
        $this->token("turnRight");
        $this->token("penDown");
        $this->token("penUp");
        $this->token("repeat");
        $this->token("clear");

        $this->token("[");
        $this->token("]");

        $this->regex('int', '@^(\d+)@');

        $this->regex('WSP', "/^[ \r\n\t]+/");
        $this->regex('CMT', '|^//.*|');

        $this->skip('WSP');
    }
}
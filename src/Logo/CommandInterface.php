<?php

namespace Logo;

interface CommandInterface
{
    public function run(Turtle $turtle, Board $board);
}
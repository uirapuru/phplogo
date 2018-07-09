<?php

namespace Logo\Board;

use Imagine\Image\Box;
use Imagine\Image\ImageInterface;
use Imagine\Image\Palette\RGB;
use Imagine\Image\Point;
use Imagine\Imagick\Imagine as RealImagine;

class Imagine
{
    /** @var  ImageInterface */
    protected $image;

    public function __construct(int $width = 320, int $height = 200, string $color = "#ffffff")
    {
        $this->image = (new RealImagine())->create(new Box($width, $height), (new RGB())->color($color, 100));
    }

    public function drawLine(int $fromX, int $fromY, int $toX, int $toY, string $color = "#000000")
    {
        $this->image->draw()->line(new Point($fromX, $fromY), new Point($toX, $toY), (new RGB())->color($color, 100));
        $this->image->save("test.png");
    }
}
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

    public function __construct()
    {
        $this->image = (new RealImagine())->create(new Box(320, 200), (new RGB())->color("#ffffff", 100));
    }

    public function drawLine(int $fromX, int $fromY, int $toX, int $toY)
    {
        $this->image->draw()->line(new Point($fromX, $fromY), new Point($toX, $toY), (new RGB())->color("#000000", 100));
        $this->image->save("test.png");
    }
}
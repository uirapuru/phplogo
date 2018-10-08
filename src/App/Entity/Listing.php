<?php

namespace App\Entity;

class Listing
{
    protected $id;

    /** @var string */
    public $listing;

    public function __construct(string $listing)
    {
        $this->listing = $listing;
    }
}
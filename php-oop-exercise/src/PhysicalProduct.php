<?php

class PhysicalProduct extends Product
{
    public function __construct(
        string  $name,
        float   $price,
        int     $quantity,
        private float $weight
    ) {
        parent::__construct($name, $price, $quantity);
    }

    public function total(): float
    {
        // price × qty × weight
        return $this->price * $this->quantity * $this->weight;
    }
}
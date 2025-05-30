<?php

class DigitalProduct extends Product
{
    public function __construct(
        string  $name,
        float   $price,
        int     $quantity,
        private string $downloadLink
    ) {
        parent::__construct($name, $price, $quantity);
    }

    public function total(): float
    {
        // No specific rules for Digital Products
        return $this->price * $this->quantity;
    }
}
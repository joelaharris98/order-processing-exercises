<?php
declare(strict_types=1);

abstract class Product
{
    public function __construct(
        protected string $name,
        protected float  $price,
        protected int    $quantity
    ) {}

    // Every product has own total method
    abstract public function total(): float;
}
<?php

class SubscriptionProduct extends Product
{
    public function __construct(
        string  $name,
        float   $price,
        int     $quantity,
        private int $durationMonths //assume monthly subscription
    ) {
        parent::__construct($name, $price, $quantity);
    }

    public function total(): float
    {
        // price × qty × duration
        return $this->price * $this->quantity * $this->durationMonths;
    }
}
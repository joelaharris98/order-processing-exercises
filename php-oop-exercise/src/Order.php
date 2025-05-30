<?php 

class Order
{
    private array $products = [];

    public function addProduct(Product $product): void
    {
        $this->products[] = $product;
    }

    public function calculateTotal(): float
    {
        $total = 0.0;
        foreach ($this->products as $product) {
            $total += $product->total();
        }

        return $total;
    }
}
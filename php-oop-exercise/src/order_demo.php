<?php
require_once __DIR__ . '/Product.php';
require_once __DIR__ . '/DigitalProduct.php';
require_once __DIR__ . '/PhysicalProduct.php';
require_once __DIR__ . '/SubscriptionProduct.php';
require_once __DIR__ . '/Order.php';


$order = new Order();

$order->addProduct(
    new DigitalProduct(
        name: 'Book',
        price: 15.00,
        quantity: 1,
        downloadLink: 'https://book.com'
    )
);

$order->addProduct(
    new PhysicalProduct(
        name: 'Phone',
        price: 5.00,
        quantity: 3,
        weight: 2
    )
);

$order->addProduct(
    new SubscriptionProduct(
        name: 'Music',
        price: 10.00,
        quantity: 2,
        durationMonths: 12
    )
);

echo 'Order total: $' . number_format($order->calculateTotal(), 2) . PHP_EOL;
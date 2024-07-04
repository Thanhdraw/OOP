<?php

class Order
{
    private string $id;
    public string $customerName;
    private float $totalValue;

    private static int $orderCount = 0;
    private static float $totalSales = 0;

    public function __construct(string $customerName, float $totalValue)
    {
        $this->id = self::generateUniqueId();
        $this->customerName = $customerName;
        $this->totalValue = $totalValue;
        self::$orderCount++;
        self::$totalSales += $totalValue;
    }

    private static function generateUniqueId(): string
    {
        return 'ORD-' . str_pad(self::$orderCount + 1, 5, '0', STR_PAD_LEFT);
    }

    public static function getOrderCount(): int
    {
        return self::$orderCount;
    }

    public static function getTotalSales(): float
    {
        return self::$totalSales;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getDescription(): string
    {
        return "Order ID: {$this->id}, Customer: {$this->customerName}, Total: $" . number_format($this->totalValue, 2);
    }
}

// Sử dụng
$order1 = new Order('John Doe', 100.50);
$order2 = new Order('Jane Smith', 75.25);
echo "<pre>";
echo $order1->getDescription() . "\n";
echo $order2->getDescription() . "\n";
echo "Total Orders: " . Order::getOrderCount() . "\n";
echo "Total Sales: $" . number_format(Order::getTotalSales(), 2) . "\n";
echo "</pre>";
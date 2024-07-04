<?php

interface LibraryItemInterface
{
    public function calculateLateFee(int $daysLate): float;
    public function getItemDetails(): string;
}

abstract class LibraryItem implements LibraryItemInterface
{
    protected string $title;
    protected string $author;
    protected string $itemCode;
    protected float $dailyLateFee;

    public function __construct(string $title, string $author, string $itemCode, float $dailyLateFee)
    {
        $this->title = $title;
        $this->author = $author;
        $this->itemCode = $itemCode;
        $this->dailyLateFee = $dailyLateFee;
    }

    public function calculateLateFee(int $daysLate): float
    {
        return $daysLate * $this->dailyLateFee;
    }

    public function getItemDetails(): string
    {
        return "{$this->title} by {$this->author} ({$this->itemCode})";
    }

    // Getters
    public function getTitle(): string
    {
        return $this->title;
    }

    public function getAuthor(): string
    {
        return $this->author;
    }

    public function getItemCode(): string
    {
        return $this->itemCode;
    }
}

class Book extends LibraryItem
{
    private const DAILY_LATE_FEE = 1000.00;

    public function __construct(string $title, string $author, string $itemCode)
    {
        parent::__construct($title, $author, $itemCode, self::DAILY_LATE_FEE);
    }
}

class DVD extends LibraryItem
{
    private const DAILY_LATE_FEE = 2000.00;

    public function __construct(string $title, string $author, string $itemCode)
    {
        parent::__construct($title, $author, $itemCode, self::DAILY_LATE_FEE);
    }
}

function processLibraryItem(LibraryItemInterface $item, int $daysLate): void
{
    $fee = $item->calculateLateFee($daysLate);
    echo "<pre>";
    echo "Late fee: {$fee}\n";
    echo "{$item->getItemDetails()}\n";
    echo "</pre>";
}

$book = new Book("Tuổi trẻ đáng giá bao nhiêu", "Rosie Nguyễn", "BOOK123");
$dvd = new DVD("The Social Network", "David Fincher", "DVD456");

processLibraryItem($book, 5);
processLibraryItem($dvd, 5);
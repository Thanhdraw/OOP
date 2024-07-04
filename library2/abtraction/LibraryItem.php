<?php

interface libraryItemInterface
{
    public function calculateLateFee($daysLate): float;

    public function getItemDescription(): string;

}


abstract class LibraryItem implements libraryItemInterface
{
    protected string $title;

    protected string $author;

    protected string $itemcode;


    public function __construct(string $title, string $author, string $itemcode)
    {
        $this->title = $title;
        $this->author = $author;
        $this->itemcode = $itemcode;
    }

}

class Book extends LibraryItem implements libraryItemInterface
{
    public string $name;

    public static int $totalBorrowed = 0;

    public function __construct(string $title, string $author, string $itemcode, string $name)
    {
        parent::__construct($title, $author, $itemcode);
        $this->name = $name;
    }

    public function borrow(): void
    {
        echo "Borrowed: " . $this->title . " by " . $this->author . " (" . $this->itemcode . ")";
        self::$totalBorrowed++ . "\n";
        echo "Total borrowed: " . self::$totalBorrowed . "\n";
    }

    public function calculateLateFee($daysLate): float
    {
        return $daysLate * 10000;
    }

    public function getItemDescription(): string
    {
        return $this->name . " and " . $this->title . " by " . $this->author . " (" . $this->itemcode . ")";
    }

}


class DVD extends LibraryItem implements libraryItemInterface
{
    public string $name;

    public function __construct(string $title, string $author, string $itemcode, string $name)
    {
        parent::__construct($title, $author, $itemcode);
        $this->name = $name;
    }

    public function calculateLateFee($daysLate): float
    {
        return $daysLate * 5000;
    }

    public function getItemDescription(): string
    {
        return $this->name . " and " . $this->title . " by " . $this->author . " (" . $this->itemcode . ")";
    }
}

function processLibraryItem(libraryItemInterface $item, int $daysLate)
{

    echo "-The item is: " . $item->getItemDescription() . "\n";
    $lateFee = $item->calculateLateFee($daysLate);
    echo "Late Fee for {$daysLate} days: " . number_format($lateFee, 2, ',', '.') . " VND\n";

}


function main()
{


    $libraryItems = [
        new Book("doisong", "Rosie Nguyễn", "BOOK123", 'Tuoi trang đáng giá bao nhiêu'),
        new DVD("The Social Network", "David Fincher", "DVD456", "author2"),
        new Book('giaoduc', "Robert C. Martin", "BOOK789", "Clean Code"),
        new DVD("Inception", "Christopher Nolan", "DVD101", "author2")
    ];

    foreach ($libraryItems as $item) {
        echo "<pre>";
        processLibraryItem($item, 3);
        if ($item instanceof Book) {
            $item->borrow();
        }
        echo "</pre>";
    }


}

main();
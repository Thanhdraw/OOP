<?php

require_once 'abtract/LibraryItem.php';

class Book extends LibraryItem
{

    public string $name;

    public function __construct(string $name, string $author, int $year)
    {
        parent::__construct($author, $year);
        $this->name = $name;
    }
    public function __destruct()
    {
        echo "Destructor: Destroying book titled '$this->name'.\n";
    }


    public function getDescription(): string
    {
        return $this->name . ' by ' . $this->author . ' (' . $this->year . ')';
    }
}


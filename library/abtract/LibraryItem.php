<?php

abstract class LibraryItem
{
    protected string $author;
    protected int $year;

    public function __construct(string $author, int $year)
    {

        $this->author = $author;
        $this->year = $year;
    }

    abstract public function getDescription(): string;
}
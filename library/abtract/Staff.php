<?php

abstract class Staff
{
    public string $name;

    protected string $position;

    public function __construct(string $name, string $position)
    {
        $this->name = $name;
        $this->position = $position;
    }

    abstract public function staffInfo();

    abstract public function getSalary();

    public function getPosition(): string
    {
        return $this->position;
    }
}
<?php

require_once 'abtract/Staff.php';


class Librarian extends Staff
{
    private float $hourlysalary;

    public function __construct($name, $position, $hourlysalary)
    {
        parent::__construct($name, $position);
        $this->hourlysalary = $hourlysalary;
    }

    public function staffInfo()
    {
        echo $this->name . " is a " . $this->position . " and his hourly salary is " . $this->hourlysalary;
    }

    public function getSalary()
    {
        return $this->hourlysalary * 10;

    }

}
<?php

require_once 'abtract/Staff.php';

class Assistant extends Staff
{
    private float $hourlyRate;
    private int $hoursWorked;

    public function __construct(string $name, string $position, float $hourlyRate, int $hoursWorked)
    {
        parent::__construct($name, $position);
        $this->hourlyRate = $hourlyRate;
        $this->hoursWorked = $hoursWorked;
    }

    #[\Override] public function getSalary()
    {
        // TODO: Implement getSalary() method.
        return $this->hourlyRate * $this->hoursWorked;
    }

    #[\Override] public function staffInfo()
    {
        // TODO: Implement staffInfo() method.
        echo $this->name . " is a " . $this->position . " and his hourly salary is " . $this->hourlyRate * $this->hoursWorked;
    }
}
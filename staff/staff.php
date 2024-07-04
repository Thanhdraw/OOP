<?php

abstract class staff
{
    public string $name;
    protected string $department;
    private string $position;

    public function __construct($name, $department, $position)
    {
        $this->name = $name;
        $this->department = $department;
        $this->position = $position;
    }

    public function getInfo()
    {
        echo $this->name . " is a " . $this->position . " and his department is " . $this->department;
    }

    abstract public function getSalary();

    public function getPosition(): string
    {
        return $this->position;
    }

    public function setPosition(string $position): void
    {
        $this->position = $position;
    }

    public function getDepartment(): string
    {
        return $this->department;
    }

    public function setDepartment(string $department): void
    {
        $this->department = $department;
    }
}

class stafffulltime extends staff
{
    private int|float $monthlysalary;

    public function __construct($name, $department, $position, $monthlysalary)
    {
        parent::__construct($name, $department, $position);
        $this->monthlysalary = $monthlysalary;
    }

    public function getSalary(): int|float
    {
        return $this->monthlysalary;
    }

    public function getInfo()
    {
        echo $this->name . " is a " . $this->getPosition() . " and his monthly salary is " . $this->monthlysalary;
    }
}

class staffparttime extends staff
{
    private int|float $hourlysalary;

    public function __construct($name, $department, $position, $hourlysalary)
    {
        parent::__construct($name, $department, $position);
        $this->hourlysalary = $hourlysalary;
    }

    public function getSalary(): int|float
    {
        return $this->hourlysalary * 10;
    }

    public function getInfo()
    {
        echo $this->name . " is a " . $this->getPosition() . " and his hourly salary is " . $this->hourlysalary;
    }
}

function printstaff(staff $staff)
{
    echo <<<HTML
    <ul>
        <li>{$staff->getInfo()}</li>
        <li>Department: {$staff->getDepartment()}</li>
        <li>Salary: {$staff->getSalary()}</li>
    </ul>
    HTML;
}

$fullTime = new stafffulltime("Nguyễn Văn A", "IT", "Manager", 5000);
$partTime = new staffparttime("Trần Thị B", "HR", "Assistant", 20);

printstaff($fullTime);
printstaff($partTime);
?>

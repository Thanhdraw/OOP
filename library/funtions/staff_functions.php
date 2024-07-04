<?php

require_once 'abtract/Staff.php';
function printStaffSalary(Staff $staff)
{
    echo $staff->name . " is a " . $staff->getPosition() . " and their salary is " . $staff->getSalary() . "\n";

}
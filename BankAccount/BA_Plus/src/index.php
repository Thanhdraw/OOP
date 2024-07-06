<?php
require __DIR__ . '/../vendor/autoload.php';

use MyCompany\MyProject\class\Bank;


$bank1 = new Bank();

$bank1 ->addAccount(new Bank(1, 'Nguyen Van A', 1000, 0, 0, new DateTime()));

<?php

require_once 'abtract/LibraryItem.php';
require_once 'abtract/Staff.php';
require_once 'class/Assistant.php';
require_once 'class/Librarian.php';
require_once 'class/Book.php';
require_once 'funtions/staff_functions.php';

$librarian = new Librarian("John Doe", "Librarian", 3000);
$assistant = new Assistant("Jane Doe", "Assistant", 15, 160);

printStaffSalary($librarian);
printStaffSalary($assistant);
echo "<br>";
$book = new Book("The Great Gatsby", "F. Scott Fitzgerald", 1925);
echo $book->getDescription() . "\n";
//$magazine = new Magazine("Time", "Time Inc.", 1234);
//echo $magazine->getDescription() . "\n";
//echo $book->borrow() . "\n";
//echo $magazine->borrow() . "\n";
//echo $book->returnItem() . "\n";
//echo $magazine->returnItem() . "\n";
?>
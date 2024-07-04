<?php

interface Transaction
{
    //    tiền gửi
    public function deposit(float $amount): void;

    //    tiền rút
    public function withdraw(float $amount): bool;

    //    kiem tra tai khoản
    public function getMyBalance(): int|float;


}

abstract class AbstractAccount implements Transaction
{
    protected int $accountNumber;
    protected static float $balance = 0;
    protected string $accountHolderName;
    protected DateTime $openDate;

    public function __construct(int $accountNumber, float $balance, string $accountHolderName, DateTime $openDate)
    {
        $this->setAccountNumber($accountNumber);
        $this->setBalance($balance);
        $this->setAccountHolderName($accountHolderName);
        $this->setOpenDate($openDate);
    }

    public function getBalance(): float
    {
        return self::$balance;
    }

    public function setBalance(float $balance): void
    {
        if (is_numeric($balance)) {
            self::$balance = $balance;
        }
    }

    public function getAccountHolderName(): string
    {
        return $this->accountHolderName;
    }

    public function setAccountHolderName(string $accountHolderName): void
    {
        if (is_string($accountHolderName)) {
            $this->accountHolderName = $accountHolderName;
        }
    }

    public function getAccountNumber(): int
    {
        return $this->accountNumber;
    }

    public function setAccountNumber(int $accountNumber): void
    {
        if (is_numeric($accountNumber)) {
            $this->accountNumber = $accountNumber;
        }
    }


    public function deposit(float $amount): void
    {
        if (is_numeric($amount)) {
            self::$balance += $amount;
        } else {
            echo 'Amount must be numeric <br>';
        }
    }

    public function withdraw(float $amount): bool
    {
        if (is_numeric($amount) && self::$balance >= $amount) {
            self::$balance -= $amount;
            return true;
        }
        return false;
    }

    public function getMyBalance(): int|float
    {
        return self::$balance;
    }

    public function getOpenDate(): DateTime
    {
        return $this->openDate;
    }

    public function setOpenDate(DateTime $openDate): void
    {
        $this->openDate = $openDate;
    }

    abstract public function getInfoMyAccount();

}

class Bank extends AbstractAccount
{

    public function __construct(int $accountNumber, float $balance, string $accountHolderName, DateTime $openDate)
    {
        parent::__construct($accountNumber, $balance, $accountHolderName, $openDate);
    }


    public function getInfoMyAccount(): void
    {

        echo 'Bank Account <br>';
        echo 'Account Number: ' . $this->getAccountNumber() . '<br>';
        echo 'Balance: ' . number_format($this->getBalance(), 2) . '<br>';
        echo 'Account Holder Name: ' . $this->getAccountHolderName() . '<br>';
        echo 'Open Date: ' . $this->getOpenDate()->format('Y-m-d-H:i:s') . '<br>';
        echo "<hr>";
    }

}


$acc1 = new Bank(1, 1200000, 'Nguyễn Thế Thế', new DateTime());

$acc1->deposit(500000);
$acc1->getInfoMyAccount();

$acc1->withdraw(550000);
$acc1->getMyBalance();
$acc1->getInfoMyAccount();



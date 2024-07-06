<?php

namespace MyCompany\MyProject\interfaces;

use DateTime;

interface Transactional
{
    public function deposit(float $amount): void;
    public function withdraw(float $amount): void;
    public function getBalance(): float;
}

abstract class AbstractAccount implements Transactional
{
    protected int $accountNumber;
    protected string $accountName;
    protected float $balance;
    protected DateTime $dateOfCreation;

    public function __construct(int $accountNumber, string $accountName, float $balance, DateTime $dateOfCreation)
    {
        $this->accountNumber = $accountNumber;
        $this->accountName = $accountName;
        $this->balance = $balance;
        $this->dateOfCreation = $dateOfCreation;
    }

    public function deposit(float $amount): void
    {
        $this->balance += $amount;
    }

    public function withdraw(float $amount): void
    {
        if ($this->balance >= $amount) {
            $this->balance -= $amount;
        } else {
            throw new \Exception("Insufficient funds");
        }
    }

    public function getBalance(): float
    {
        return $this->balance;
    }

    public function getAccountNumber(): int
    {
        return $this->accountNumber;
    }

    abstract public function getAccountDescription(): string;
}

class SavingsAccount extends AbstractAccount
{
    private float $interestRate;

    public function __construct(int $accountNumber, string $accountName, float $balance, DateTime $dateOfCreation, float $interestRate)
    {
        parent::__construct($accountNumber, $accountName, $balance, $dateOfCreation);
        $this->interestRate = $interestRate;
    }

    public function getAccountDescription(): string
    {
        return sprintf("Savings Account - Number: %d, Name: %s, Balance: %.2f, Interest Rate: %.2f%%",
            $this->accountNumber, $this->accountName, $this->balance, $this->interestRate * 100);
    }
}

class Bank
{
    private array $accounts = [];

    public function addAccount(AbstractAccount $account): void
    {
        $this->accounts[] = $account;
    }

    public function getAccountDescription(int $accountNumber): string
    {
        foreach ($this->accounts as $account) {
            if ($account->getAccountNumber() === $accountNumber) {
                return $account->getAccountDescription();
            }
        }
        throw new \Exception("Account not found");
    }
}

// Usage
$bank = new Bank();
$savingsAccount = new SavingsAccount(1, 'Nguyen Van A', 1000, new DateTime('2022-01-01'), 0.05);
$bank->addAccount($savingsAccount);

echo $bank->getAccountDescription(1);
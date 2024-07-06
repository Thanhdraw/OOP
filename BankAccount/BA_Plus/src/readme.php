<?php

class BankAccount {
    private $accountNumber;
    private $balance;

    public function __construct($accountNumber, $initialBalance = 0) {
        $this->accountNumber = $accountNumber;
        $this->balance = $initialBalance;
    }

    public function deposit($amount) {
        if ($amount > 0) {
            $this->balance += $amount;
            return true;
        }
        return false;
    }

    public function withdraw($amount) {
        if ($amount > 0 && $this->balance >= $amount) {
            $this->balance -= $amount;
            return true;
        }
        return false;
    }

    public function getBalance() {
        return $this->balance;
    }

    public function getAccountNumber() {
        return $this->accountNumber;
    }
}

class Bank {
    private $accounts = [];

    public function createAccount($accountNumber, $initialBalance = 0) {
        $account = new BankAccount($accountNumber, $initialBalance);
        $this->accounts[$accountNumber] = $account;
        return $account;
    }

    public function getAccount($accountNumber) {
        return $this->accounts[$accountNumber] ?? null;
    }

    public function transferMoney($fromAccountNumber, $toAccountNumber, $amount) {
        $fromAccount = $this->getAccount($fromAccountNumber);
        $toAccount = $this->getAccount($toAccountNumber);

        if ($fromAccount && $toAccount && $fromAccount->withdraw($amount)) {
            $toAccount->deposit($amount);
            return true;
        }
        return false;
    }
}

// Sử dụng hệ thống
$bank = new Bank();

// Tạo tài khoản
$account1 = $bank->createAccount("1001", 1000);
$account2 = $bank->createAccount("1002", 500);

// Thực hiện giao dịch
$account1->deposit(200);
$account2->withdraw(100);

// Chuyển tiền
$bank->transferMoney("1001", "1002", 300);

// Kiểm tra số dư
echo "Số dư tài khoản 1001: " . $account1->getBalance() . "\n";
echo "Số dư tài khoản 1002: " . $account2->getBalance() . "\n";
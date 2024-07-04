<?php

/**
 * Interface for transactional operations
 */
interface Transactional
{
    public function deposit(float $amount): void;

    public function withdraw(float $amount): bool;

    public function getBalance(): float;
}

/**
 * Abstract base class for all account types
 */
abstract class AbstractAccount implements Transactional
{
    protected string $accountNumber;
    protected string $accountHolderName;
    protected float $balance;
    protected DateTime $openDate;

    protected static int $totalAccounts = 0;
    protected static float $totalBankBalance = 0;

    public function __construct(string $accountHolderName, float $initialDeposit)
    {
        $this->accountNumber = $this->generateAccountNumber();
        $this->accountHolderName = $accountHolderName;
        $this->balance = $initialDeposit;
        $this->openDate = new DateTime();

        self::$totalAccounts++;
        self::$totalBankBalance += $initialDeposit;
    }

    abstract protected function generateAccountNumber(): string;

    public function deposit(float $amount): void
    {
        if ($amount <= 0) {
            throw new InvalidArgumentException("Deposit amount must be positive.");
        }
        $this->balance += $amount;
        self::$totalBankBalance += $amount;
    }

    public function withdraw(float $amount): bool
    {
        if ($amount <= 0) {
            throw new InvalidArgumentException("Withdrawal amount must be positive.");
        }
        if ($this->balance < $amount) {
            return false;
        }
        $this->balance -= $amount;
        self::$totalBankBalance -= $amount;
        return true;
    }

    public function getBalance(): float
    {
        return $this->balance;
    }

    public function getAccountInfo(): string
    {
        return sprintf(
            "Account: %s, Holder: %s, Balance: $%.2f, Opened: %s",
            $this->accountNumber,
            $this->accountHolderName,
            $this->balance,
            $this->openDate->format('Y-m-d H:i:s')
        );
    }

    public static function getTotalAccounts(): int
    {
        return self::$totalAccounts;
    }

    public static function getTotalBankBalance(): float
    {
        return self::$totalBankBalance;
    }
}

/**
 * Savings Account class
 */
class SavingsAccount extends AbstractAccount
{
    private float $interestRate;

    public function __construct(string $accountHolderName, float $initialDeposit, float $interestRate)
    {
        parent::__construct($accountHolderName, $initialDeposit);
        $this->interestRate = $interestRate;
    }

    protected function generateAccountNumber(): string
    {
        return "SAV-" . str_pad(self::$totalAccounts + 1, 6, '0', STR_PAD_LEFT);
    }

    public function addInterest(): void
    {
        $interest = $this->balance * $this->interestRate;
        $this->deposit($interest);
    }
}

/**
 * Checking Account class
 */
class CheckingAccount extends AbstractAccount
{
    private float $overdraftLimit;

    public function __construct(string $accountHolderName, float $initialDeposit, float $overdraftLimit)
    {
        parent::__construct($accountHolderName, $initialDeposit);
        $this->overdraftLimit = $overdraftLimit;
    }

    protected function generateAccountNumber(): string
    {
        return "CHK-" . str_pad(self::$totalAccounts + 1, 6, '0', STR_PAD_LEFT);
    }

    public function withdraw(float $amount): bool
    {
        if ($amount <= 0) {
            throw new InvalidArgumentException("Withdrawal amount must be positive.");
        }
        if ($this->balance + $this->overdraftLimit < $amount) {
            return false;
        }
        $this->balance -= $amount;
        self::$totalBankBalance -= $amount;
        return true;
    }
}

/**
 * Bank class to manage accounts and operations
 */
class Bank
{
    private array $accounts = [];

    public function addAccount(AbstractAccount $account): void
    {
        $this->accounts[] = $account;
    }

    public function transferMoney(AbstractAccount $from, AbstractAccount $to, float $amount): bool
    {
        if ($from->withdraw($amount)) {
            $to->deposit($amount);
            return true;
        }
        return false;
    }

    public function getTotalAccounts(): int
    {
        return AbstractAccount::getTotalAccounts();
    }

    public function getTotalBalance(): float
    {
        return AbstractAccount::getTotalBankBalance();
    }

    public function generateReport(): string
    {
        $report = "<h2>Bank Report</h2>";
        $report .= "<table border='1' cellpadding='5' cellspacing='0'>";
        $report .= "<tr><th>Total Accounts</th><th>Total Balance</th></tr>";
        $report .= sprintf("<tr><td>%d</td><td>$%.2f</td></tr>",
            $this->getTotalAccounts(),
            $this->getTotalBalance());
        $report .= "</table><br>";

        $report .= "<h3>Account Details</h3>";
        $report .= "<table border='1' cellpadding='5' cellspacing='0'>";
        $report .= "<tr><th>Account Number</th><th>Holder</th><th>Balance</th><th>Open Date</th></tr>";
        foreach ($this->accounts as $account) {
            $info = explode(", ", $account->getAccountInfo());
            $report .= "<tr>";
            foreach ($info as $detail) {
                $parts = explode(": ", $detail);
                $report .= "<td>" . $parts[1] . "</td>";
            }
            $report .= "</tr>";
        }
        $report .= "</table>";

        return $report;
    }


}

// Usage example
try {
    $bank = new Bank();

    // Create accounts
    $savings = new SavingsAccount("Alice Smith", 1000, 0.05);
    $checking = new CheckingAccount("Bob Johnson", 500, 100);

    // Add accounts to the bank
    $bank->addAccount($savings);
    $bank->addAccount($checking);

    // Perform some transactions
    $savings->deposit(200);
    $checking->withdraw(100);
    $savings->addInterest();

    // Transfer money between accounts
    $bank->transferMoney($savings, $checking, 300);

    // Generate and display the bank report
    echo $bank->generateReport();

} catch (Exception $e) {
    echo "An error occurred: " . $e->getMessage();
}
<?php

declare(strict_types=1);

namespace App\Tests\Model\Transaction\Services;

use App\Entity\Account;
use App\Exception\CheckTransactionException;
use App\Model\Transaction\Services\CheckTransationService;
use PHPUnit\Framework\TestCase;

class CheckTransactionServiceTest extends TestCase
{
    private CheckTransationService $checkTransaction;

    private Account $account;

    public function setUp(): void
    {
        $this->checkTransaction = new CheckTransationService();
        $this->account = (new Account())->setBalance(200);
    }

    public function tearDown(): void
    {
        parent::tearDown();
    }

    public function testPassCheckNotNegativeAmount()
    {
        $this->assertEquals(true, $this->checkTransaction->checkNotNegativeAmount(1000));
    }

    public function testFailCheckNotNegativeAmount()
    {
        $this->expectException(CheckTransactionException::class);
        $this->checkTransaction->checkNotNegativeAmount(-10);
    }

    public function testPassCheckAccountBalance()
    {
        $this->assertEquals(true, $this->checkTransaction->checkAccountBalance($this->account, 100));
    }

    public function testFailCheckAccountBalance()
    {
        $this->expectException(CheckTransactionException::class);
        $this->checkTransaction->checkAccountBalance($this->account, 300);
    }
}
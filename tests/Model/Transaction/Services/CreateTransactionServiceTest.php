<?php

declare(strict_types=1);

namespace App\Tests\Model\Transaction\Services;

use App\Entity\User;
use App\Exception\CheckTransactionException;
use App\Model\Transaction\Services\CheckTransationService;
use App\Model\Transaction\Services\CreateTransactionService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CreateTransactionServiceTest extends KernelTestCase
{
    private $em;
    private $createTransactionService;
    private $userRepository;
    private $fromUser;
    private $toUser;

    public function setUp(): void
    {
        $kernel = self::bootKernel();
        $this->em = $kernel->getContainer()->get('doctrine')->getManager();
        $this->createTransactionService = new CreateTransactionService($this->em, new CheckTransationService());
        $this->userRepository = $this->em->getRepository(User::class);
        $this->fromUser = $this->userRepository->findByEmail('example1@example.com');
        $this->toUser = $this->userRepository->findByEmail('example2@example.com');
    }

    public function tearDown(): void
    {
        parent::tearDown();
        $this->em->close();
    }

    public function testPassCreateTransaction(): void
    {
        $transaction = $this->createTransactionService->create($this->fromUser, $this->toUser, 10);
        $this->assertEquals(10, $transaction->getAmount());
        $this->assertEquals($this->fromUser->getAccount(), $transaction->getCreditAccount());
        $this->assertEquals($this->toUser->getAccount(), $transaction->getDebitAccount());
    }

    public function testFailCreateTransactionNegativeAmount(): void
    {
        $this->expectException(CheckTransactionException::class);
        $transaction = $this->createTransactionService->create($this->fromUser, $this->toUser, -1000);
    }

    public function testFailCreateTransactionNegativeBalance(): void
    {
        $this->expectException(CheckTransactionException::class);
        $transaction = $this->createTransactionService->create($this->fromUser, $this->toUser, 1000);
    }
}
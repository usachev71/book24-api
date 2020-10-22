<?php

declare(strict_types=1);

namespace App\Model\Transaction\Create;

use App\Model\Transaction\Services\CreateTransactionService;
use App\Repository\AccountRepository;
use App\Repository\TransactionRepository;
use App\Repository\UserRepository;

class CreateHandler
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var CreateTransactionService
     */
    private CreateTransactionService $createTransaction;

    /**
     * CreateHandler constructor.
     * @param UserRepository $userRepository
     */
    public function __construct(
        UserRepository $userRepository,
        CreateTransactionService $createTransaction
    ) {
        $this->userRepository = $userRepository;
        $this->createTransaction = $createTransaction;
    }

    /**
     * @param CreateCommand $command
     */
    public function handler(CreateCommand $command): void
    {
        $fromUser = $this->userRepository->findByEmail($command->from_user);
        $toUser = $this->userRepository->findByEmail($command->to_user);

        $this->createTransaction->create($fromUser, $toUser, $command->amount);
    }
}
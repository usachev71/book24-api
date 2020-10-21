<?php

declare(strict_types=1);

namespace App\Model\Transaction\Create;

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
     * @var AccountRepository
     */
    private $accountRepository;

    /**
     * @var TransactionRepository
     */
    private $transactionRepository;

    /**
     * CreateHandler constructor.
     * @param UserRepository $userRepository
     * @param AccountRepository $accountRepository
     * @param TransactionRepository $transactionRepository
     */
    public function __construct(
        UserRepository $userRepository,
        AccountRepository $accountRepository,
        TransactionRepository $transactionRepository
    ) {
        $this->userRepository = $userRepository;
        $this->accountRepository = $accountRepository;
        $this->transactionRepository = $transactionRepository;
    }

    /**
     * @param CreateCommand $command
     */
    public function handler(CreateCommand $command): void
    {
        $fromUser = $this->userRepository->findByEmail($command->from_user);
        $toUser = $this->userRepository->findByEmail($command->to_user);


    }
}
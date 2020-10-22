<?php

declare(strict_types=1);

namespace App\Model\Transaction\Services;

use App\Entity\Transaction;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class CreateTransactionService
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;

    /**
     * @var CheckTransationService
     */
    private CheckTransationService $checkTransaction;

    /**
     * CreateTransactionService constructor.
     * @param EntityManagerInterface $entityManager
     * @param CheckTransationService $checkTransaction
     */
    public function __construct(EntityManagerInterface $entityManager, CheckTransationService $checkTransaction)
    {
        $this->entityManager = $entityManager;
        $this->checkTransaction = $checkTransaction;
    }

    /**
     * @param User $creditUser
     * @param User $debitUser
     * @param int $amount
     * @return Transaction
     */
    public function create(User $creditUser, User $debitUser, int $amount): Transaction
    {
        return $this->entityManager->transactional(
            function($em) use ($creditUser, $debitUser, $amount) {
                $debitAccount = $debitUser->getAccount();
                $creditAccount = $creditUser->getAccount();

                $this->checkTransaction->checkNotNegativeAmount($amount);
                $this->checkTransaction->checkAccountBalance($creditAccount, $amount);

                $debitAccount->setBalance($debitAccount->getBalance() + $amount);
                $creditAccount->setBalance($creditAccount->getBalance() - $amount);

                $transaction = new Transaction($debitAccount, $creditAccount, $amount);

                $em->persist($transaction);
                $em->flush();

                return $transaction;
            }
        );
    }
}
<?php

declare(strict_types=1);

namespace App\Model\Transaction\Services;

use App\Entity\Account;
use App\Exception\CheckTransactionException;
use Symfony\Component\HttpFoundation\Response;

class CheckTransationService
{
    /**
     * @param Account $account
     * @param int $amount
     * @return bool
     */
    public function checkAccountBalance(Account $account, int $amount): bool
    {
        if ($account->getBalance() < $amount) {
            throw new CheckTransactionException('Недостаточно средств для перевода', Response::HTTP_BAD_REQUEST);
        }
        return true;
    }

    /**
     * @param $amount
     * @return bool
     */
    public function checkNotNegativeAmount($amount): bool
    {
        if ($amount < 0) {
            throw new CheckTransactionException('Нельзя использовать отрицательное значение', Response::HTTP_BAD_REQUEST);
        }
        return true;
    }
}
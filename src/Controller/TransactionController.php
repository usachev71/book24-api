<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class TransactionController extends AbstractController
{
    /**
     * @Route("/transaction", methods={"POST"}, name="transactionCreate")
     * @return JsonResponse
     */
    public function create(): JsonResponse
    {
        return $this->json([]);
    }
}
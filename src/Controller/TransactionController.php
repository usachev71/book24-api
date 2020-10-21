<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\Transaction\Create\CreateCommand;
use App\Model\Transaction\Create\CreateForm;
use App\Model\Transaction\Create\CreateHandler;
use PhpParser\JsonDecoder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TransactionController extends AbstractController
{
    /**
     * @Route("/transaction", methods={"POST"}, name="transactionCreate")
     * @param Request $request
     * @param CreateHandler $createHandler
     * @return JsonResponse
     */
    public function create(Request $request, CreateHandler $createHandler): JsonResponse
    {
        $command = new CreateCommand();
        $decoder = new JsonDecoder();

        $form = $this->createForm(CreateForm::class, $command);
        $data = $decoder->decode($request->getContent());
        $form->submit($data);

        if ($form->isValid()) {
            try {
                $createHandler->handler($command);
                return $this->json(["message" => "Условные единицы успешно переведены"], Response::HTTP_OK);
            } catch (\DomainException $e) {
                return $this->json(["message" => $e->getMessage()], $e->getCode());
            }
        }

        return $this->json(["message" => "Некорректный запрос"], Response::HTTP_BAD_REQUEST);
    }
}
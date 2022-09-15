<?php

namespace App\Controller;

use App\Repository\AccountRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BalanceController extends AbstractController
{

    private AccountRepository $repository;

    public function __construct(AccountRepository $repository)
    {
        $this->repository = $repository;
    }

    #[Route('/balance', name: 'app_balance')]
    public function showAccountBalance(Request $request): JsonResponse
    {
        $accountId = $request->query->get('account_id')?? null;

        $account = $this->repository->find($accountId) ?? null;
        return $this->json(!is_null($account) ? $account : 0, $account ? 200 : 404);
    }
}

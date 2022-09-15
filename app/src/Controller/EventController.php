<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\AccountService;
use Composer;

class EventController extends AbstractController
{

    private AccountService $service;

    public function __construct(AccountService $service)
    {
        $this->service = $service;
    }

    #[Route('/event', name: 'app_event', methods: ['POST'])]
    public function handle(Request $request)
    {
        $requestData = json_decode($request->getContent());
        switch ($requestData->type) {
            case 'deposit':
                $depositOperation = $this->service->deposit($requestData->destination, (float)$requestData->amount);
                return new JsonResponse(['destination' => $depositOperation],201);
            case 'withdraw':
                $withdrawOperation = $this->service->withdraw($requestData->origin, (float)$requestData->amount);
                if($withdrawOperation) {
                    return new JsonResponse(['origin' => $withdrawOperation],201);
                }
                return new JsonResponse(0,404);
            case 'transfer':
                $transferOperation = $this->service->transfer($requestData->origin, $requestData->destination, (float)$requestData->amount);
                if($transferOperation) {
                    return new JsonResponse(['origin' => $this->service->retrieveAccount($requestData->origin), 'destination' => $this->service->retrieveAccount($requestData->destination)],201);
                }
                return new JsonResponse(0,404);
        }
        return 0;
    }

}

<?php

namespace App\Controller;

use Doctrine\DBAL\Exception;
use Doctrine\Migrations\Exception\MigrationException;
use DoctrineMigrations\Version20220915005840;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Routing\Annotation\Route;

class ResetController extends AbstractController
{

    private KernelInterface $kernel;

    public function __construct(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    #[Route('/reset', name: 'app_reset', methods: ['POST'])]
    public function reset()
    {

        try {
            // Drop old database
            exec('php bin/console doctrine:database:drop --force');

            exec('php bin/console doctrine:database:create');

            return new Response('OK', Response::HTTP_OK);
        } catch (\Exception $exception) {
            return new JsonResponse('ERROR', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}

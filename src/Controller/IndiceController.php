<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class IndiceController extends AbstractController
{
    #[Route('/', name: 'app_indice')]
    public function index(): Response
    {
        return $this->render('indice/index.html.twig', [
            'controller_name' => 'IndiceController',
        ]);
    }
}

<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EsdController extends AbstractController
{
    #[Route('/esd', name: 'app_esd')]
    public function index(): Response
    {
        return $this->render('esd/index.html.twig', [
            'controller_name' => 'EsdController',
        ]);
    }
}

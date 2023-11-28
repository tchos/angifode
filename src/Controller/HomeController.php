<?php

namespace App\Controller;

use App\Services\Services;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/')]
    public function indexNoLocale(): Response
    {
        return $this->redirectToRoute('app_home', ['_locale' => 'fr']);
    }

    #[Route('/{_locale<%app.supported_locales%>}/', name: 'app_home')]
    public function index(Services $statistiques): Response
    {
        // 'nbUsers', 'nbOrganismes', 'nbAgentsDetaches'
        $stats = $statistiques->getStats();

        return $this->render('home/home.html.twig', [
            'stats' => $stats,
        ]);
    }
}

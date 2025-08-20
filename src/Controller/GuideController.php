<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[IsGranted('ROLE_USER')]
class GuideController extends AbstractController
{
    #[Route('/{_locale<%app.supported_locales%>}/guide', name: 'app_guide')]
    public function index(): Response
    {
        return $this->render('guide/guide.html.twig');
    }
}

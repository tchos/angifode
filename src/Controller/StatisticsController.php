<?php

namespace App\Controller;

use App\Form\EsdType;
use App\Form\SearchYearType;
use App\Services\Services;
use App\Services\BI;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Require ROLE_USER for all the actions of this controller
 */
#[IsGranted('ROLE_USER')]
class StatisticsController extends AbstractController
{
    #[Route('/statistics', name: 'app_statistics')]
    public function index(Services $statistiques): Response
    {
        // 'nbUsers', 'nbOrganismes', 'nbAgentsDetaches'
        $stats = $statistiques->getStats();

        return $this->render('statistics/statistics.html.twig', [
            'stats' => $stats,
        ]);
    }

    #[Route('/statistics/totalsaryear', name: 'totalsaryear')]
    public function totalSARByYear(BI $bi, Services $statistiques)
    {
        // 'nbUsers', 'nbOrganismes', 'nbAgentsDetaches'
        $stats = $statistiques->getStats();

        $totalsaryear = $bi->getSarByYear();
        return $this->render('statistics/totalsaryear.html.twig', [
            'stats' => $stats,
            'totalsaryear' => $totalsaryear,
        ]);
    }

    #[Route('/statistics/totalsaryearorganisme', name: 'totalsaryearorganisme')]
    public function totalSARByYearByOrganisme(BI $bi, Services $statistiques)
    {
        // 'nbUsers', 'nbOrganismes', 'nbAgentsDetaches'
        $stats = $statistiques->getStats();

        $totalsaryearorganisme = $bi->getSarByYearByOrganisme();
        return $this->render('statistics/totalsaryearorganisme.html.twig', [
            'stats' => $stats,
            'totalsaryearorganisme' => $totalsaryearorganisme,
        ]);
    }

    # Affiche le total des sommes reversées par trim pour une année donnée
    #[Route('/statistics/sartrim/{year<\d+>?2022}', name: 'sartrim')]
    public function sarByTrimByOrganisme(Request $request, BI $bi, Services $statistiques, String $year)
    {
        $year = date('Y');
        // 'nbUsers', 'nbOrganismes', 'nbAgentsDetaches'
        $stats = $statistiques->getStats();
        $sartrim = $bi->getSarByTrimByOrganisme($year);

        // constructeur du formulaire qui va capter les dates de début et de fin
        $form = $this->createForm(SearchYearType::class);

        // handlerequest() permet de parcourir la requête et d'extraire les informations du formulaire
        $form->handleRequest($request);

        /**
         * Ayant extrait les infos saisies dans le formulaire,
         * on vérifie que le formulaire a été soumis et qu'il est valide
         */
        if($form->isSubmitted() && $form->isValid())
        {
            $year = $form->get('year')->getData();
            $sartrim = $bi->getSarByTrimByOrganisme($year);
        }

        return $this->render('statistics/sartrim.html.twig', [
            'form' => $form->createView(),
            'stats' => $stats,
            'sartrim' => $sartrim,
            'year' => $year,
        ]);
    }

    #[Route('/statistics/anypayinyear', name: 'anypayinyear')]
    public function anyPayInYear(BI $bi, Services $statistiques)
    {
        // 'nbUsers', 'nbOrganismes', 'nbAgentsDetaches'
        $stats = $statistiques->getStats();
        $anypayinyear = $bi->getAnyPayInYear();

        return $this->render('statistics/anypayinyear.html.twig', [
            'stats' => $stats,
            'anypayinyear' => $anypayinyear,
        ]);
    }

    #[Route('/statistics/neverpay', name: 'neverpay')]
    public function neverPay(BI $bi, Services $statistiques)
    {
        // 'nbUsers', 'nbOrganismes', 'nbAgentsDetaches'
        $stats = $statistiques->getStats();
        $neverpay = $bi->getAnyPayInYear();

        return $this->render('statistics/neverpay.html.twig', [
            'stats' => $stats,
            'neverpay' => $neverpay,
        ]);
    }

    #[Route('/statistics/nbredetache', name: 'nbredetache')]
    public function numberDetacheByOrganisme(BI $bi, Services $statistiques)
    {
        // 'nbUsers', 'nbOrganismes', 'nbAgentsDetaches'
        $stats = $statistiques->getStats();
        $nbredetache = $bi->getNbreDetacheByOrganisme();

        return $this->render('statistics/nbredetache.html.twig', [
            'stats' => $stats,
            'nbredetache' => $nbredetache,
        ]);
    }

    #[Route('/statistics/newdetachebyyear', name: 'newdetachebyyear')]
    public function newDetacheByYear(BI $bi, Services $statistiques)
    {
        // 'nbUsers', 'nbOrganismes', 'nbAgentsDetaches'
        $stats = $statistiques->getStats();
        $newdetachebyyear = $bi->getNewDetacheByYear();

        return $this->render('statistics/newdetachebyyear.html.twig', [
            'stats' => $stats,
            'newdetachebyyear' => $newdetachebyyear
        ]);
    }
}

<?php

namespace App\Controller;

use App\Services\Services;
use App\Services\BI;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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

    #[Route('/statistics/anyreversementinyear', name: 'anyreversementinyear')]
    public function anyReversementInYear(BI $bi, Services $statistiques)
    {
        // 'nbUsers', 'nbOrganismes', 'nbAgentsDetaches'
        $stats = $statistiques->getStats();
        $anyreversementinyear = $bi->getAnyReversementInYear();

        return $this->render('statistics/anyreversementinyear.html.twig', [
            'stats' => $stats,
            'anyreversementinyear' => $anyreversementinyear,
        ]);
    }
}

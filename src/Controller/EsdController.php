<?php

namespace App\Controller;

use App\Entity\Historique;
use App\Entity\Organismes;
use App\Entity\TypeBareme;
use App\Form\EsdType;
use App\Form\ReversementType;
use App\Repository\BaremeRepository;
use App\Repository\OrganismesRepository;
use App\Repository\TypeBaremeRepository;
use App\Services\Services;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Require ROLE_USER for all the actions of this controller
 */
#[IsGranted('ROLE_USER')]
class EsdController extends AbstractController
{
    #[Route('/esd/{id}', name: 'esd_evaluate')]
    public function index(Services $services, Organismes $organisme, Request $request): Response
    {
        // utilisateur connecté
        $user = $this->getUser();
        // pour l'historisation de l'action
        $history = new Historique();

        // constructeur de formulaire de creation d'un organisme
        $form = $this->createForm(EsdType::class);

        // handlerequest() permet de parcourir la requête et d'extraire les informations du formulaire
        $form->handleRequest($request);

        /**
         * Ayant extrait les infos saisies dans le formulaire,
         * on vérifie que le formulaire a été soumis et qu'il est valide
         */
        if($form->isSubmitted() && $form->isValid())
        {
            $dateDebut = $form->get('dateDebRev')->getData();
            $dateFin = $form->get('dateFinRev')->getData();
            $sar = $services->getSommeAReverser($dateDebut, $dateFin, 1);
            //$sb = $services->getSalaire(date_create("2007-11-01"), date_create("2008-03-30"), "42210", "2", "01");

            $periodes = $services->getPeriodes($dateDebut, $dateFin);
            $tableau = [];
            foreach ($periodes as $date){
                $tableau[] = date_create($date);
            }
            dd($periodes);
            //dd($sar);
        }

        return $this->render('esd/esd_orga.html.twig', [
            'form' => $form->createView(),
            'organisme' => $organisme
        ]);
    }

    #[Route('/esd', name: 'esd_orga')]
    public function listOrganisme(Services $services, OrganismesRepository $organismesRepository): Response
    {
        return $this->render('esd/orga.html.twig', [
            'listeOrganismes' => $organismesRepository->findAll(),
        ]);
    }
}

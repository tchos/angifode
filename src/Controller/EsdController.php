<?php

namespace App\Controller;

use App\Entity\AgentDetache;
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

            $sar = $services->getSommeAReverser($dateDebut, $dateFin, 420, "42210", date_create("1995-11-01"));
            $totalSar = 0;
            $dataSar = [];

            //dd($sar);
            for ($i = 0; $i < count($sar); $i++) {
                $totalSar += $sar[$i]["sar"];
            }
            $dataSar[] = $totalSar;


            //$periodes = $services->getPeriodes($dateDebut, $dateFin);
            //dd($periodes);

            // Alerte succès de l'enregistrement d'un nouveau détachement
            $this->addFlash("success","La dette de l'organisme ". $organisme->getSigle() ." a été évaluée avec succès !!!");

            return $this->render('esd/esd_result.html.twig', [
                'dateDebut' => $dateDebut->format('d-m-Y'),
                'dateFin' => $dateFin->format('d-m-Y'),
                'dataSar' => $dataSar,
                'sar' => $sar,
                'totalSar' => $totalSar,
                'organisme' => $organisme
            ]);
        }

        return $this->render('esd/esd_orga.html.twig', [
            'form' => $form->createView(),
            'organisme' => $organisme
        ]);
    }
    /** Fin esd_evaluate */


    #[Route('/esd/agent/{id}∕{dateDebut}/{dateFin}', name: 'esd_agent_details')]
    public function detailsESDAgent(Services $services, AgentDetache $agentDetache, Request $request,
        \DateTime $dateDebut, \DateTime $dateFin): Response
    {
        $sar = $services->getSommeAReverser($dateDebut, $dateFin, 420, "42210", date_create("1995-11-01"));
        $totalSar = 0;

        for ($i = 0; $i < count($sar); $i++) {
            $totalSar += $sar[$i]["sar"];
        }
        return $this->render('esd/esd_details.html.twig',[
            'sar' => $sar,
            'totalSar' => $totalSar,
            'agentDetache' => $agentDetache
        ]);
    }
    /** Fin esd_agent_details */


    #[Route('/esd', name: 'esd_orga')]
    public function listOrganisme(Services $services, OrganismesRepository $organismesRepository): Response
    {
        if($this->getUser()->getOrganisme()->getSigle() === "MINFI" | $this->isGranted('ROLE_ADMIN'))
            $listeOrganismes = $organismesRepository->findAll();
        else
            $listeOrganismes = $organismesRepository->findBy(['id' => $this->getUser()->getOrganisme()]);

        return $this->render('esd/orga.html.twig', [
            'listeOrganismes' => $listeOrganismes,
        ]);
    }
}
